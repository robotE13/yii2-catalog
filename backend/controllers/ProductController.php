<?php

namespace robote13\catalog\backend\controllers;

use yii\web\NotFoundHttpException;
use robote13\yii2components\web\CrudControllerAbstract;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends CrudControllerAbstract
{

    public function getModelClass()
    {
        return 'robote13\catalog\models\Product';
    }

    public function getSearchClass()
    {
        return 'robote13\catalog\forms\ProductSearch';
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
