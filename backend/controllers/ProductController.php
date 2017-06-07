<?php

namespace robote13\catalog\backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use robote13\yii2components\web\CrudControllerAbstract;
use sidanval\tabular\TabularForm;
use robote13\catalog\models\Leftover;

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

    public function actions()
    {
        return[
            'update-editable'=>[
                'class'=> \robote13\yii2components\web\EditableAction::className(),
                'modelClass'=> \robote13\catalog\models\Product::className()
            ]
        ];
    }

    public function init()
    {
        $this->indexViewParams = function($searchModel,$dataProvider){
            $dataProvider->query->with('type');
            return['dataProvider'=>$dataProvider];
        };
        parent::init();
    }

    /*public function actionCreate()
    {
        $tabular = Yii::createObject([
            'class'=> TabularForm::className(),
            'withRoot'=>true,
            'rootModel'=>Yii::createObject($this->modelClass),
            'rootModelAttribute'=>'leftovers',
            'modelsGetter'=>function(){return [Yii::createObject(Leftover::className())];},
            'modelsAttribute'=>'product'
        ]);

        if ($tabular->load(Yii::$app->request->post()) && $tabular->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $tabular->rootModel,
                'leftovers'=>$tabular->models
            ]);
        }
    }*/

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param mixed $id
     * @return mixed
     */
    /*public function actionUpdate()
    {
        $id = Yii::$app->getRequest()->get('id');
        $tabular = Yii::createObject([
            'class'=> TabularForm::className(),
            'withRoot'=>true,
            'rootModel'=>$this->findModel($id),
            'rootModelAttribute'=>'leftovers',
            //'modelsGetter'=>function(){return [Yii::createObject(Leftover::className())];},
            'modelsAttribute'=>'product'
        ]);

        if ($tabular->load(Yii::$app->request->post()) && $tabular->save()) {
            return $this->redirect(Url::previous("{$this->id}-index"));
        } else {
            return $this->render('update', [
                'model' => $tabular->rootModel,
                'leftovers' => !empty($tabular->models)?$tabular->models:[Yii::createObject(Leftover::className())]
            ]);
        }
    }*/

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
