<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\RelatedProduct */

$this->title = $model->product_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('robote13/catalog', 'Related Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="related-product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('robote13/catalog', 'Update'), ['update', 'product_id' => $model->product_id, 'related_id' => $model->related_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('robote13/catalog', 'Delete'), ['delete', 'product_id' => $model->product_id, 'related_id' => $model->related_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('robote13/catalog', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'product_id',
            'related_id',
        ],
    ]) ?>

</div>
