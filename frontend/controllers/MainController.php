<?php

namespace robote13\catalog\frontend\controllers;

use robote13\yii2components\web\FrontendControllerAbstract;

/**
 * Default controller for the `shop-catalog` module
 */
class MainController extends FrontendControllerAbstract
{
    public function getModelClass()
    {
        return '\robote13\catalog\models\Product';
    }

    public function getSearchClass()
    {
        return '\robote13\catalog\forms\ProductSearch';
    }

    public function actionView($id)
    {
        $this->findModelCallback = function ($query,$id){
            return $query->bySlug($id)->active();
        };
        return parent::actionView($id);
    }
}
