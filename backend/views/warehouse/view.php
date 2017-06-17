<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\grid\GridView;

/* @var $this yii\web\View */
$this->title = Yii::t('robote13/catalog', 'Leftovers: {title}', [
    'title' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('robote13/catalog', 'Warehouses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<?=GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$filter,
    'columns'=>[
        [
            'attribute'=>'vendor_code',
            'value'=>function($model){return $model->product->vendor_code;}
        ],
        [
            'attribute'=>'title',
            'value'=>function($model){return $model->product->title;}
        ],
        'left_in_stock',
        'reserved'
    ]
])?>