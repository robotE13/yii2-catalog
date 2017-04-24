<?php

namespace robote13\catalog\models;

/**
 * This is the ActiveQuery class for [[Leftover]].
 *
 * @see Leftover
 */
class LeftoverQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Leftover[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Leftover|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
