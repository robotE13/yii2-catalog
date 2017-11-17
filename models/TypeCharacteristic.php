<?php

namespace robote13\catalog\models;

use Yii;
use yii\helpers\Json;
use robote13\catalog\forms\EnumerableItem;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%type_characteristic}}".
 *
 * @property int $id
 * @property string $attribute
 * @property string $label
 * @property integer $data_type
 * @property int $type_id
 * @property \robote13\catalog\forms\EnumerableItem[] $items enumerable items for the attribute if data_type is self::TYPE_ENUMERABLE
 *
 * @property-read string $validator Description
 * @property ProductType $type
 */
class TypeCharacteristic extends \yii\db\ActiveRecord
{
    const TYPE_STRING = 1;
    const TYPE_TEXT = 2;
    const TYPE_INT = 3;
    const TYPE_DECIMAL = 4;
    const TYPE_ENUMERABLE = 5;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%type_characteristic}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute', 'label', 'type_id','data_type'], 'required'],
            [['type_id','data_type'], 'integer'],
            [['attribute', 'label'], 'string', 'max' => 255],
            [['type_id', 'attribute'], 'unique', 'targetAttribute' => ['type_id', 'attribute']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('robote13/catalog', 'ID'),
            'attribute' => Yii::t('robote13/catalog', 'Attribute'),
            'label' => Yii::t('robote13/catalog', 'Label'),
            'data_type' => Yii::t('robote13/catalog', 'Data type'),
            'type_id' => Yii::t('robote13/catalog', 'Type ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'type_id']);
    }

    public function afterFind()
    {
        parent::afterFind();
        if(isset($this->items))
        {
            $items = [];
            foreach (Json::decode($this->items) as $key => $item)
            {
                array_push($items, new EnumerableItem([
                    'key'=>$key,
                    'value'=>$item
                ]));
            }
            $this->items = $items;
        }
    }

    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert))
            return false;

        $this->items = $this->data_type == static::TYPE_ENUMERABLE ?
                       Json::encode(array_reduce($this->items,function($carry,$item){
                           $carry[$item->key] = $item->value;
                           return $carry;
                       },[])) :  null;
        return true;
    }

    /**
     *
     * @param \yii\widgets\ActiveForm $form
     * @param \yii\base\Model $model
     * @param string $attribute
     * @param array $options the additional configurations for the field object. These are properties of [[ActiveField]]
     * or a subclass, depending on the value of [[fieldClass]]
     * @param array $inputOptions {@see \yii\widgets\ActiveField::$inputOptions}
     */
    public static function fieldHelper($form,$model,$attribute,$options=[],$inputOptions = ['class' => 'form-control'])
    {
        $characteristic = static::find()->where(['type_id'=>$model->typeId,'attribute'=>$attribute])->one();
        return $characteristic->field($form,$model,$options,$inputOptions);
    }

    /**
     *
     * @param \yii\widgets\ActiveForm $form
     * @param \yii\base\Model $model
     * @param array $options the additional configurations for the field object. These are properties of [[ActiveField]]
     * or a subclass, depending on the value of [[fieldClass]]
     * @param array $inputOptions {@see \yii\widgets\ActiveField::$inputOptions}
     */
    public function field($form,$model,$options = [],$inputOptions = ['class' => 'form-control'])
    {
        $field = $form->field($model, $this->attribute,$options);
        switch ($this->data_type)
        {
            case static::TYPE_STRING:
            case static::TYPE_INT:
            case static::TYPE_DECIMAL:
                return $field->textInput($inputOptions);
            case static::TYPE_TEXT:
                return $field->textarea($inputOptions);
            case static::TYPE_ENUMERABLE:
                return $field->dropDownList(ArrayHelper::map($this->items, 'key', 'value'),$inputOptions);
            default:
                return $field->textInput($inputOptions);
        }
    }

    /**
     *
     * @return string validator name or 'unknown'
     */
    public function getValidator()
    {
        switch ($this->data_type)
        {
            case static::TYPE_STRING:
            case static::TYPE_TEXT:
                return 'string';
            case static::TYPE_INT:
            case static::TYPE_ENUMERABLE:
                return 'integer';
            case static::TYPE_DECIMAL:
                return 'number';
            default:
                return 'unknown';
        }
    }
}
