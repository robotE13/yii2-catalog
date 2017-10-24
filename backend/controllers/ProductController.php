<?php

namespace robote13\catalog\backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use robote13\catalog\models\DynamicAttributes;
use robote13\catalog\models\ProductType;
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

    public function actionCreate()
    {
        $typeId = Yii::$app->request->get('type_id');
        $productType = ProductType::findOne($typeId);
        $model = Yii::createObject(['class'=>$this->modelClass,'type_id'=> $productType->id]);
        $attributes = Yii::createObject(DynamicAttributes::className());

        DynamicAttributes::$table = $productType->dynamicTableName;
        $dynamicLoaded = $attributes->load(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post()) && Model::validateMultiple([$model,$attributes]))
        {
            $model->save(false);
            if($dynamicLoaded){
                $attributes->link('product',$model);
            }
            return $this->redirect(['index']);
        }
        return $this->render('create',compact('model','attributes'));
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param mixed $id
     * @return mixed
     *
    public function actionUpdate()
    {
        $id = Yii::$app->getRequest()->get('id');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Url::previous("{$this->id}-index"));
        } else {
            return $this->render('update', [
                'model' => $model,
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
