<?php

namespace robote13\catalog\backend\controllers;

use yii\web\NotFoundHttpException;
use robote13\yii2components\web\CrudControllerAbstract;

/**
 * ProductTypeController implements the CRUD actions for ProductType model.
 */
class ProductTypeController extends CrudControllerAbstract
{

    public function getModelClass()
    {
        return 'robote13\catalog\models\ProductType';
    }

    public function getSearchClass()
    {
        return 'robote13\catalog\forms\ProductTypeSearch';
    }

    /**
     * Displays a single ProductType model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
