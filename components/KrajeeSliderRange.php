<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace robote13\catalog\components;

use yii\helpers\ArrayHelper;

/**
 *
 * @author Tartharia
 */
trait KrajeeSliderRange
{
    private $_min_price = 0;

    private $_max_price;

    public function setPriceRange($priceRange)
    {
        $ranges = explode(',', $priceRange);
        $this->_min_price = ArrayHelper::getValue($ranges, 0);
        $this->_max_price = ArrayHelper::getValue($ranges, 1);
    }


    public function getPriceRange()
    {
        return implode(',', [$this->_min_price, isset($this->_max_price)?$this->_max_price:PHP_INT_MAX]);
    }
}
