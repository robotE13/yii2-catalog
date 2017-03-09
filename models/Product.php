<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%catalog_product}}".
 *
 * @property int $id
 * @property int $type_id
 * @property string $slug_index
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property int $measurement_unit_id
 * @property string $price
 *
 * @property MeasurementUnit $measurementUnit
 * @property ProductType $type
 * @property CategoryProduct[] $categoryProducts
 * @property CatalogCategory[] $categories
 * @property SetProduct[] $setProducts
 * @property CatalogSet[] $sets
 * @property WarehouseProduct[] $warehouseProducts
 * @property CatalogWarehouse[] $warehouses
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'slug_index', 'slug', 'title', 'description', 'measurement_unit_id', 'price'], 'required'],
            [['type_id', 'measurement_unit_id'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['slug_index'], 'string', 'max' => 32],
            [['slug', 'title'], 'string', 'max' => 255],
            [['measurement_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => MeasurementUnit::className(), 'targetAttribute' => ['measurement_unit_id' => 'id']],
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
            'type_id' => Yii::t('robote13/catalog', 'Type ID'),
            'slug_index' => Yii::t('robote13/catalog', 'Slug Index'),
            'slug' => Yii::t('robote13/catalog', 'Slug'),
            'title' => Yii::t('robote13/catalog', 'Title'),
            'description' => Yii::t('robote13/catalog', 'Description'),
            'measurement_unit_id' => Yii::t('robote13/catalog', 'Measurement Unit ID'),
            'price' => Yii::t('robote13/catalog', 'Price'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeasurementUnit()
    {
        return $this->hasOne(MeasurementUnit::className(), ['id' => 'measurement_unit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ProductType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryProducts()
    {
        return $this->hasMany(CategoryProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(CatalogCategory::className(), ['id' => 'category_id'])->viaTable('{{%category_product}}', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetProducts()
    {
        return $this->hasMany(SetProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSets()
    {
        return $this->hasMany(CatalogSet::className(), ['id' => 'set_id'])->viaTable('{{%set_product}}', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouseProducts()
    {
        return $this->hasMany(WarehouseProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouses()
    {
        return $this->hasMany(CatalogWarehouse::className(), ['id' => 'warehouse_id'])->viaTable('{{%warehouse_product}}', ['product_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }
}
