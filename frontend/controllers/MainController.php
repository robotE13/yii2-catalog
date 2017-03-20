<?php

namespace robote13\catalog\frontend\controllers;

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

    public function actionView($id)
    {
        return $this->render('view',['model'=> $this->findModel($id)]);
    }

    protected function findModel($id)
    {
        if(($model = \robote13\catalog\models\Product::find()->bySlug($id)->active()->one()))
        {
            return $model;
        }
        throw new \yii\web\NotFoundHttpException(\Yii::t('app', 'Requested page not found'));
    }
}
