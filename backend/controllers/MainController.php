<?php

namespace robote13\catalog\backend\controllers;

use yii\web\Controller;

/**
 * Default controller for the `shop-catalog` module
 */
class MainController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
