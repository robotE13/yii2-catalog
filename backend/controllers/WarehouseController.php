<?php

namespace robote13\catalog\backend\controllers;

use yii\web\NotFoundHttpException;
use robote13\yii2components\web\CrudControllerAbstract;

/**
 * WarehouseController implements the CRUD actions for Warehouse model.
 */
class WarehouseController extends CrudControllerAbstract
{
    public function getModelClass()
    {
        return 'robote13\catalog\models\Warehouse';
    }

    public function getSearchClass()
    {
        return 'robote13\catalog\forms\WarehouseSearch';
    }

    /**
     * Deletes an existing Warehouse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
