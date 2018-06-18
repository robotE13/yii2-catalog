<?php

namespace robote13\catalog\models;

/**
 * This is the ActiveQuery class for [[Product]].
 *
 * @see Product
 */
class ProductQuery extends \yii\db\ActiveQuery
{
    /**
     *
     * @return ProductQuery
     */
    public function active()
    {
        return $this->andWhere(['status'=> [Product::STATUS_IN_STOCK, Product::STATUS_NOT_IN_STOCK]]);
    }

    public function type($type)
    {
        DynamicAttributes::$table = ProductType::find()->select('table')->where(['id'=>$type])->scalar();
        return $this->andWhere(['type_id'=>$type]);
    }

    public function typeAlias($type)
    {
        DynamicAttributes::$table = $type;
        return $this->andWhere(['type_id'=>ProductType::find()->select('id')->where(['table'=>$type])->scalar()]);
    }

    public function withCategories($category,$joinType = 'LEFT JOIN')
    {
        return !empty($category) ? $this->joinWith(['categories'=>function($query) use($category){
            return $query->alias('category')->andOnCondition(['category.slug'=> $category]);
        }],true, $joinType) : $this;
    }

    public function bySlug($slug)
    {
        return $this->andWhere(['slug_index'=> md5($slug)]);
    }

    /**
     * @inheritdoc
     * @return Product[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Product|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
