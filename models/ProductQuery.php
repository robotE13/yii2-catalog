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

    public function typeId($typeId)
    {
        return $this->andWhere(['type_id'=>$typeId]);
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
