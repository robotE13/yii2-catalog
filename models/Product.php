<?php

namespace robote13\catalog\models;

use Yii;
use robote13\yii2components\behaviors\IndexedStringBehavior;
use robote13\yii2components\behaviors\TextStatusBehavior;

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
 * @property char $origin_country
 * @property string $price
 * @property int $status
 * @property string $textStatus
 *
 * @property MeasurementUnit $measurementUnit
 * @property ProductType $type
 * @property CategoryProduct[] $categoryProducts
 * @property Category[] $categories
 * @property SetProduct[] $setProducts
 * @property Set[] $sets
 * @property WarehouseProduct[] $warehouseProducts
 * @property Warehouse[] $warehouses
 */
class Product extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 2;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_product}}';
    }

    public function behaviors()
    {
        return [
            'indexed'=>[
                'class'=> IndexedStringBehavior::className(),
                'attribute' => 'slug',
                'indexAttribute' => 'slug_index'
            ],
            'textStatus'=>[
                'class'=> TextStatusBehavior::className(),
                'attributes'=>[
                    'status'=> static::getStatuses()
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id','slug', 'title', 'description', 'measurement_unit_id', 'price','origin_country'], 'required'],
            [['type_id', 'measurement_unit_id'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['slug', 'title'], 'string', 'max' => 255],
            ['status','in','range'=> array_keys(static::getStatuses())],
            [['measurement_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => MeasurementUnit::className(), 'targetAttribute' => ['measurement_unit_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    public static function getStatuses()
    {
        return[
            self::STATUS_ACTIVE => Yii::t('robote13/catalog', 'Active'),
            self::STATUS_DELETED => Yii::t('robote13/catalog', 'Deleted')
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
            'origin_country' => Yii::t('robote13/catalog', 'Origin'),
            'price' => Yii::t('robote13/catalog', 'Price'),
            'textStatus' => Yii::t('robote13/catalog', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeasurementUnit()
    {
        return $this->hasOne(MeasurementUnit::className(), ['id' => 'measurement_unit_id']);
    }

    public function getDynamicAttributes()
    {
        return $this->hasOne(DynamicAttributes::className(),['product_id'=>'id']);
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
        return $this->hasMany(Category::className(), ['id' => 'category_id'])->via('categoryProducts');
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
        return $this->hasMany(Set::className(), ['id' => 'set_id'])->via('setProducts');
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
        return $this->hasMany(Warehouse::className(), ['id' => 'warehouse_id'])->via('warehouseProducts');
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
