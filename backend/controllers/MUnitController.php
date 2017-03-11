<?php

namespace robote13\catalog\backend\controllers;

use yii\web\NotFoundHttpException;
use robote13\yii2components\web\CrudControllerAbstract;

/**
 * MUnitController implements the CRUD actions for MeasurementUnit model.
 */
class MUnitController extends CrudControllerAbstract
{

    public function getModelClass()
    {
        return 'robote13\catalog\models\MeasurementUnit';
    }

    public function getSearchClass()
    {
        return 'robote13\catalog\forms\MeasurementUnitSearch';
    }

    /**
     * Displays a single MeasurementUnit model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
