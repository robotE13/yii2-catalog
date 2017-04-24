<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
                'value'=>function($model){return $model->type->title;},
                'filter'=> robote13\catalog\models\ProductType::dropdownItems('title','id')
            ],
            'slug',
            'price',
            [
                'attribute'=>'status',
                'filter'=> \robote13\catalog\models\Product::getStatuses(),
                'value'=>'statusText'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
