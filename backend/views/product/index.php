<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\editable\Editable;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel robote13\catalog\forms\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('robote13/catalog', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('robote13/catalog', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'vendor_code',
            'title',
            [
                'attribute'=>'type_id',
                'value'=>function($model){return yii\helpers\ArrayHelper::getValue($model->type,'title');},
                'filter'=> robote13\catalog\models\ProductType::dropdownItems('id','title')
            ],
            'slug',
            [
                'attribute'=>'price',
                'content'=>function($model,$key,$index,$column){
                    return Editable::widget([
                        'options'=>[ 'id'=>"editable-price-{$index}"],
                        'model'=>$model,
                        'attribute'=>'price',
                        'beforeInput'=>function($form,$widget){
                            return Html::hiddenInput('editableKey', $widget->model->primaryKey);
                        },
                        'asPopover'=>false,
                        'ajaxSettings'=>[
                            'url'=> Url::to(['update-editable'])
                        ]
                    ]);
                },
            ],
            [
                'attribute'=>'popularity',
                'content'=>function($model,$key,$index,$column){
                    return Editable::widget([
                        'options'=>[ 'id'=>"editable-{$index}"],
                        'model'=>$model,
                        'attribute'=>'popularity',
                        'beforeInput'=>function($form,$widget){
                            return Html::hiddenInput('editableKey', $widget->model->primaryKey);
                        },
                        'asPopover'=>false,
                        'ajaxSettings'=>[
                            'url'=> Url::to(['update-editable'])
                        ]
                    ]);
                },
                'filter'=>false
            ],
            [
                'attribute'=>'status',
                'filter'=> \robote13\catalog\models\Product::getStatuses(),
                'value'=>'statusText'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons'=>[
                    'view' => function ($url,$model,$key){
                        return Html::a(Html::tag('span','',['class'=>'glyphicon glyphicon-link']), ['related/index','id'=>$model->id]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
