<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%product_type}}".
 *
 * @property int $id
 * @property string $title
 *
 * @property CatalogProduct[] $catalogProducts
 * @property TypeCharacteristic[] $typeCharacteristics
 */
class ProductType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('robote13/catalog', 'ID'),
            'title' => Yii::t('robote13/catalog', 'Title'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogProducts()
    {
        return $this->hasMany(CatalogProduct::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeCharacteristics()
    {
        return $this->hasMany(TypeCharacteristic::className(), ['type_id' => 'id']);
    }
}
