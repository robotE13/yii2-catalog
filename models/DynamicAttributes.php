<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace robote13\catalog\models;

/**
 * Description of Profile
 *
 * @author Tartharia
 */
class DynamicAttributes extends \yii\db\ActiveRecord
{
    public static $table = null;

    public static function tableName()
    {
        if(!static::$table)
        {
            throw new \LogicException('При использовании связи `dynamicAttributes` вы должны задать тип продукта при помощи ProductQuery::type($type). Присоединение таблицы специфичных для типа характеристик без указания типа невозможно');
        }
        return static::$table;
    }
}
