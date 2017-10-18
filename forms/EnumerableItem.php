<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace robote13\catalog\forms;

/**
 * Description of EnumerableItem
 *
 * @author Tartharia
 */
class EnumerableItem extends \yii\base\Model
{
    public $key;

    public $value;

    public function rules()
    {
        return [
            ['key','integer','min'=>1],
            ['value','match','pattern'=>'/^[A-Za-z\s\d]+$/u']
        ];
    }
}
