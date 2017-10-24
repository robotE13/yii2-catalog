<?php

namespace robote13\catalog\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%catalog_product}}".
 *
 * @property int $id
 * @property int $type_id
 * @property string $slug
 * @property string $slug_index
 * @property string $title product name
 * @property string $badge badge for product card
 * @property string $description product description
 * @property string $vendor_code
 * @property int $measurement_unit_id
 * @property char $origin_country
 * @property string $price
 * @property integer $status
 * @property integer $popularity
 * @property string $updated_in
 *
 * @property string $textStatus
 * @property-read boolean $isAvailable
 * @property Leftover[] $leftovers
 * @property MeasurementUnit $measurementUnit
 * @property ProductType $type
 * @property Product[] $related "с этим товаром покупают"
 * @property Set[] $sets
 * @property SetProduct[] $setProducts
 * @property Warehouse[] $warehouses
 */
class Product extends ProductBase
{

    const STATUS_ARCHIVE = 4;
    const STATUS_NOT_IN_STOCK = 3;
    const STATUS_DELETED = 2;
    const STATUS_IN_STOCK = 1;

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
            [['type_id','slug','vendor_code', 'title', 'description', 'measurement_unit_id', 'price','origin_country'], 'required'],
            [['type_id', 'measurement_unit_id','popularity'], 'integer'],
            [['description','badge'], 'string'],
            [['price'], 'number'],
            [['slug', 'title','vendor_code'], 'string', 'max' => 255],
            ['vendor_code','unique','skipOnError'=>true],
            ['status','in','range'=> array_keys(static::getStatuses())],
            [['measurement_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => MeasurementUnit::className(), 'targetAttribute' => ['measurement_unit_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    public static function getStatuses()
    {
        return[
            self::STATUS_IN_STOCK => Yii::t('robote13/catalog', 'In stock'),
            self::STATUS_NOT_IN_STOCK => Yii::t('robote13/catalog', 'Not in stock'),
            self::STATUS_ARCHIVE => Yii::t('robote13/catalog', 'Archive'),
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
            'vendor_code' => Yii::t('robote13/catalog', 'Vendor Code'),
            'description' => Yii::t('robote13/catalog', 'Description'),
            'measurement_unit_id' => Yii::t('robote13/catalog', 'Measurement units'),
            'origin_country' => Yii::t('robote13/catalog', 'Origin'),
            'price' => Yii::t('robote13/catalog', 'Price'),
            'status' => Yii::t('robote13/catalog', 'Status'),
            'popularity' => Yii::t('robote13/catalog', 'Popularity'),
            'textStatus' => Yii::t('robote13/catalog', 'Status'),
        ];
    }

    public function getIsAvailable()
    {
        return in_array($this->status,[
            static::STATUS_IN_STOCK,
            static::STATUS_NOT_IN_STOCK
        ]);
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
        if(!$this->isNewRecord){
            DynamicAttributes::$table = $this->type->dynamicTableName;
        }
        return $this->hasOne(DynamicAttributes::className(),['product_id'=>'id'])->inverseOf('product');
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
    public function getCharacteristics()
    {
        return $this->hasMany(TypeCharacteristic::className(), ['type_id' => 'id'])->via('type');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedProducts()
    {
        return $this->hasMany(RelatedProduct::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelated()
    {
        return $this->hasMany(Product::className(), ['id'=>'related_id'])->via('relatedProducts');
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
    public function getLeftovers()
    {
        return $this->hasMany(Leftover::className(), ['product_id' => 'id']);
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
