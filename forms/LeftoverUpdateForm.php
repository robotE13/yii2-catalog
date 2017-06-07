<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace robote13\catalog\forms;

/**
 * Description of LeftoverUpdateForm
 *
 * @author Tartharia
 */
class LeftoverUpdateForm extends \yii\base\Model
{
    public $warehouse_id;

    public $product_id;

    public $quantity;

    public function rules()
    {
        return [
            [['quantity','product_id','warehouse_id'],'required'],
            ['quantity','integer','min'=>1],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['warehouse_id'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::className(), 'targetAttribute' => ['warehouse_id' => 'id']]
        ];
    }
}
