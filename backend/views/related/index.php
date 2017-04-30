<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel robote13\catalog\models\RelatedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
Yii::$app->user->returnUrl = Url::to(['product/index']);
$this->title = Yii::t('robote13/catalog', 'Related Products');
$this->params['breadcrumbs'][] = ['url'=> Url::previous("product-index"),'label'=>Yii::t('robote13/catalog', 'Products')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="related-product-index">
    <div class="panel panel-default">
        <div class="panel-heading"><?=Yii::t('robote13/catalog', 'Create Related Product')?></div>
        <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(['id'=>'view-index']); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
           'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                  'related.vendor_code',
                  'related.title',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}'
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
