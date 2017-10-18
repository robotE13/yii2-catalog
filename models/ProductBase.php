<?php


namespace robote13\catalog\models;

use robote13\yii2components\behaviors\IndexedStringBehavior;
use robote13\yii2components\behaviors\TextStatusBehavior;

/**
 * Base class for Set and Product models.
 *
 */
class ProductBase extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return[
            'indexed'=>[
                'class'=> IndexedStringBehavior::className(),
                'attribute' => 'slug',
                'indexAttribute' => 'slug_index'
            ],
            'textStatus'=>[
                'class'=> TextStatusBehavior::className(),
                'attributes'=>[
                    'status'=> static::getStatuses()
                ]
            ],
        ];
    }
}
