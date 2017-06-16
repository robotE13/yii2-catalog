<?php

namespace robote13\catalog\backend\controllers;

use yii\web\NotFoundHttpException;
use robote13\yii2components\web\CrudControllerAbstract;

/**
 * SetController implements the CRUD actions for Set model.
 */
class SetController extends CrudControllerAbstract
{

    public function getModelClass()
    {
        return 'robote13\catalog\models\Set';
    }

    public function getSearchClass()
    {
        return 'robote13\catalog\forms\SetSearch';
    }

    public function actions()
    {
        return[
            'update-editable'=>[
                'class'=> \robote13\yii2components\web\EditableAction::className(),
                'modelClass'=> \robote13\catalog\models\Set::className()
            ]
        ];
    }

    /**
     * Displays a single Set model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
