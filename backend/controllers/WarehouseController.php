<?php

namespace robote13\catalog\backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use robote13\catalog\models\LeftoverOperation;
use sidanval\tabular\TabularForm;
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

    public function actionIncome($id)
    {
        Yii::$container->set(LeftoverOperation::className(),['type'=> LeftoverOperation::TYPE_INCOME]);
        $tabular = Yii::createObject([
            'class'=> TabularForm::className(),
            'withRoot'=>false,
            'rootModel'=>$this->findModel($id),
            'rootModelAttribute'=>'operations',
            'modelsGetter'=>function(){
                return [Yii::createObject(['class'=> LeftoverOperation::className()])];
            },
            'deleteCallback' => function(){return true;},
            'modelsAttribute'=>'warehouse'
        ]);

        if ($tabular->load(Yii::$app->request->post()) && $tabular->save()) {
            return $this->redirect(Url::previous("{$this->id}-index"));
        } else {
            return $this->render('income', [
                'model' => $tabular->rootModel,
                'operations' => $tabular->models
            ]);
        }
    }
}
