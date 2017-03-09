<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%catalog_set}}".
 *
 * @property int $id
 * @property string $slug_index
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $discount_amount
 *
 * @property SetProduct[] $setProducts
 * @property CatalogProduct[] $products
 */
class Set extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_set}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug_index', 'slug', 'title', 'description', 'discount_amount'], 'required'],
            [['description'], 'string'],
            [['discount_amount'], 'number'],
            [['slug', 'title'], 'string', 'max' => 255],
            [['slug_index'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('robote13/catalog', 'ID'),
            'slug_index' => Yii::t('robote13/catalog', 'Slug Index'),
            'slug' => Yii::t('robote13/catalog', 'Slug'),
            'title' => Yii::t('robote13/catalog', 'Title'),
            'description' => Yii::t('robote13/catalog', 'Description'),
            'discount_amount' => Yii::t('robote13/catalog', 'Discount Amount'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetProducts()
    {
        return $this->hasMany(SetProduct::className(), ['set_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(CatalogProduct::className(), ['id' => 'product_id'])->viaTable('{{%set_product}}', ['set_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return SetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SetQuery(get_called_class());
    }
}
