<?php

namespace robote13\catalog\backend\controllers;

use Yii;
use robote13\catalog\models\RelatedProduct;
use robote13\catalog\models\RelatedSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RelatedController implements the CRUD actions for RelatedProduct model.
 */
class RelatedController extends Controller
{
    public function actions()
    {
        return[
            'products-list'=>[
                'class'=> \robote13\yii2components\web\Select2GetListAction::className(),
                'modelClass' => \robote13\catalog\models\Product::className(),
                'searchAttribute' => 'title'
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all RelatedProduct models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $model = new RelatedProduct(['product_id'=>$id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model = new RelatedProduct(['product_id'=>$id]);
        }

        $searchModel = new RelatedSearch(['product_id'=>$id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'product' => \robote13\catalog\models\Product::find()->where(['id'=>$id])->select('title')->scalar(),
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing RelatedProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $product_id
     * @param integer $related_id
     * @return mixed
     */
    public function actionDelete($product_id, $related_id)
    {
        $this->findModel($product_id, $related_id)->delete();

        return $this->redirect(['index','id'=>$product_id]);
    }

    /**
     * Finds the RelatedProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $product_id
     * @param integer $related_id
     * @return RelatedProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($product_id, $related_id)
    {
        if (($model = RelatedProduct::findOne(['product_id' => $product_id, 'related_id' => $related_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
