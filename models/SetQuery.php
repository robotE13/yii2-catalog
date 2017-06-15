<?php

namespace robote13\catalog\models;

/**
 * This is the ActiveQuery class for [[Set]].
 *
 * @see Set
 */
class SetQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['status'=> Set::STATUS_ENABLED]);
    }

    public function bySlug($slug)
    {
        return $this->andWhere(['slug_index'=> md5($slug)]);
    }

    /**
     * @inheritdoc
     * @return Set[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Set|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
