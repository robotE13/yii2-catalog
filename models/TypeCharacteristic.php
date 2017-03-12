<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%type_characteristic}}".
 *
 * @property int $id
 * @property string $attribute
 * @property string $label
 * @property integer $data_type
 * @property int $type_id
 *
 * @property ProductType $type
 */
class TypeCharacteristic extends \yii\db\ActiveRecord
{
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
}
