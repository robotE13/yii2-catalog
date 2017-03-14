<?php

namespace robote13\catalog\models;

/**
 * This is the ActiveQuery class for [[Product]].
 *
 * @see Product
 */
class ProductQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status'=> Product::STATUS_ACTIVE]);
    }

    public function type($type)
    {
        DynamicAttributes::$table = ProductType::find()->select('table')->where(['id'=>$type])->scalar();
        return $this->andWhere(['type_id'=>$type]);
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
