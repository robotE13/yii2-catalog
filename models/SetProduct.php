<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%set_product}}".
 *
 * @property int $set_id
 * @property int $product_id
 *
 * @property CatalogProduct $product
 * @property CatalogSet $set
 */
class SetProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%set_product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['set_id', 'product_id'], 'required'],
            [['set_id', 'product_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogProduct::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['set_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogSet::className(), 'targetAttribute' => ['set_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'set_id' => Yii::t('robote13/catalog', 'Set ID'),
            'product_id' => Yii::t('robote13/catalog', 'Product ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(CatalogProduct::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSet()
    {
        return $this->hasOne(CatalogSet::className(), ['id' => 'set_id']);
    }
}
