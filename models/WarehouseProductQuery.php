<?php

namespace robote13\catalog\models;

/**
 * This is the ActiveQuery class for [[WarehouseProduct]].
 *
 * @see WarehouseProduct
 */
class WarehouseProductQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return WarehouseProduct[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WarehouseProduct|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
