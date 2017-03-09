<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%catalog_warehouse}}".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 *
 * @property WarehouseProduct[] $warehouseProducts
 * @property CatalogProduct[] $products
 */
class Warehouse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_warehouse}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
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
            'description' => Yii::t('robote13/catalog', 'Description'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouseProducts()
    {
        return $this->hasMany(WarehouseProduct::className(), ['warehouse_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(CatalogProduct::className(), ['id' => 'product_id'])->viaTable('{{%warehouse_product}}', ['warehouse_id' => 'id']);
    }
}
