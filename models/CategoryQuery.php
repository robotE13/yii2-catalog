<?php

namespace robote13\catalog\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * This is the ActiveQuery class for [[Category]].
 *
 * @see Category
 */
class CategoryQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            'nestedSetsQuery' => NestedSetsQueryBehavior::className(),
        ];
    }

    public function bySlug($slug)
    {
        return $this->andWhere(['slug_index'=> md5($slug)]);
    }

    /**
     * @inheritdoc
     * @return Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
