<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "warehouse_product".
 *
 * @property int $warehouse_id
 * @property int $product_id
 * @property int $left_in_stock
 * @property int $reserved
 *
 * @property Product $product
 * @property Warehouse $warehouse
 */
class Leftover extends \yii\db\ActiveRecord
{
    const SCENARIO_REMAINS = 'remains';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%leftover}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['warehouse_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'warehouse_id' => Yii::t('robote13/catalog', 'Warehouse ID'),
            'product_id' => Yii::t('robote13/catalog', 'Product ID'),
            'left_in_stock' => Yii::t('robote13/catalog', 'Left In Stock'),
            'reserved' => Yii::t('robote13/catalog', 'Reserved'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse_id']);
    }

    public static function incomeMultiple()
    {

    }

    /**
     * @inheritdoc
     * @return WarehouseProductQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LeftoverQuery(get_called_class());
    }
}
