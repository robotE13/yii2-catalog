<?php

namespace robote13\catalog\models;

use Yii;
use yii\helpers\Json;
use robote13\catalog\forms\EnumerableItem;

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
        foreach (Json::decode($this->items) as $item)
        {
            $this->items[] = new EnumerableItem([
                'key'=>$item['key'],
                'value'=>$item['value']
            ]);
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
}
