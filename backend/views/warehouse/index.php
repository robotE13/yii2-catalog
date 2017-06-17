<?php

use yii\helpers\Html;
use yii\grid\GridView;
use robote13\catalog\models\LeftoverOperation;

/* @var $this yii\web\View */
/* @var $searchModel robote13\catalog\forms\WarehouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('robote13/catalog', 'Warehouses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('robote13/catalog', 'Create Warehouse'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            'description:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>"{income} {expense} {view} {update} {delete}",
                'buttons'=>[
                    'view' => function ($url,$model,$key){
                        return Html::a(Html::tag('span','',['class'=>'glyphicon glyphicon-th-list']), ['view','warehouse_id'=>$model->id]);
                    },
                    'income' => function ($url,$model,$key){
                        return Html::a(Html::tag('span','',['class'=>'glyphicon glyphicon-plus']), ['operation','id'=>$model->id,'type'=> LeftoverOperation::TYPE_INCOME]);
                    },
                    'expense' => function ($url,$model,$key){
                        return Html::a(Html::tag('span','',['class'=>'glyphicon glyphicon-minus']), ['operation','id'=>$model->id,'type'=> LeftoverOperation::TYPE_EXPENSE]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
