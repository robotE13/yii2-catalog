<?php

namespace robote13\catalog\backend\controllers;

use Yii;
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

    public function init()
    {
        $this->indexViewParams = function($searchModel,$dataProvider){
            $dataProvider->query->with('type');
            return['dataProvider'=>$dataProvider];
        };
        parent::init();
    }

    public function actionCreate()
    {
        $model = Yii::createObject($this->modelClass);
        $leftovers = [Yii::createObject(\robote13\catalog\models\Leftover::className())];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'leftovers'=>$leftovers
            ]);
        }
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
