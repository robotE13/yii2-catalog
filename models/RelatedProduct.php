<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%related_product}}".
 *
 * @property int $product_id
 * @property int $related_id
 *
 * @property Product $product
 * @property Product $related
 */
class RelatedProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%related_product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'exist', 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['related_id'], 'exist', 'targetClass' => Product::className(), 'targetAttribute' => ['related_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'related_id' => 'Related ID',
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
    public function getRelated()
    {
        return $this->hasOne(Product::className(), ['id' => 'related_id']);
    }
}
