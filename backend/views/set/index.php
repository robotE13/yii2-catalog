<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel robote13\catalog\forms\SetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('robote13/catalog', 'Sets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="set-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('robote13/catalog', 'Create Set'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute'=>'status',
                'filter'=> \robote13\catalog\models\Set::getStatuses(),
                'value'=>'statusText'
            ],
            'slug',
            'title',
            'discount_amount',
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
                'class' => 'yii\grid\ActionColumn',
                'template'=>"{update} {delete}"
            ],
        ],
    ]); ?>
</div>
