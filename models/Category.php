<?php

namespace robote13\catalog\models;

use Yii;

/**
 * This is the model class for table "{{%catalog_category}}".
 *
 * @property int $id
 * @property string $slug_index
 * @property string $slug
 * @property string $title
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 *
 * @property CategoryProduct[] $categoryProducts
 * @property CatalogProduct[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slug_index', 'slug', 'title', 'lft', 'rgt', 'depth'], 'required'],
            [['lft', 'rgt', 'depth'], 'integer'],
            [['slug_index'], 'string', 'max' => 32],
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
            'lft' => Yii::t('robote13/catalog', 'Lft'),
            'rgt' => Yii::t('robote13/catalog', 'Rgt'),
            'depth' => Yii::t('robote13/catalog', 'Depth'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryProducts()
    {
        return $this->hasMany(CategoryProduct::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(CatalogProduct::className(), ['id' => 'product_id'])->viaTable('{{%category_product}}', ['category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}
