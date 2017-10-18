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

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id'=>'product_id'])->inverseOf('dynamicAttributes');
    }

    public function attributes()
    {
        try{
            $attributes = parent::attributes();
        } catch (\yii\base\InvalidConfigException $e){
            return[];
        }
        return $attributes;
    }

    public function rules()
    {
        $rules = [];
        $attributes = TypeCharacteristic::find()->innerJoinWith('type')->where(['table'=> str_replace(['p_','{{%','}}'], '', static::tableName())])->all();
        foreach ($attributes as $attribute)
        {
            $rules[] = $this->createRule($attribute);
        }
        $rules[]=[array_keys($this->getAttributes(null, ['product_id'])),'required'];
        return $rules;
    }

    private function createRule($attribute)
    {
        switch ($attribute->data_type)
        {
            case TypeCharacteristic::TYPE_INT:
                return[$attribute->attribute,'integer'];
            case TypeCharacteristic::TYPE_ENUMERABLE:
                return[$attribute->attribute,'in','range'=> \yii\helpers\ArrayHelper::getColumn($attribute->items,'key')];
            case TypeCharacteristic::TYPE_DECIMAL:
                return[$attribute->attribute,'number'];
            default:
                return[$attribute->attribute,'filter','filter'=>'strip_tags'];
        }
    }
}
