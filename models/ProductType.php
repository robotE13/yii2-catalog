<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%product_type}}".
 *
 * @property int $id
 * @property string $title
 * @property string $table
 *
 * @property Product[] $catalogProducts
 * @property TypeCharacteristic[] $typeCharacteristics
 */
class ProductType extends \yii\db\ActiveRecord
{
    use \robote13\yii2components\traits\DropdownItemsTrait;
    const CACHE_KEY_DROPDOWN = 'robote13_catalog_dropdown_items';
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
            [['title','table'], 'required'],
            [['title'], 'string', 'max' => 255],
            ['table','match','pattern'=>'/^[a-z]{1}[a-z\_]{1,}[a-z]{1}$/']
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
            'table' => Yii::t('robote13/catalog', 'Alias'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogProducts()
    {
        return $this->hasMany(Product::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeCharacteristics()
    {
        return $this->hasMany(TypeCharacteristic::className(), ['type_id' => 'id']);
    }
}
