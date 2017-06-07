<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\Product */
/* @var $leftovers robote13\catalog\models\Leftover[] */

$this->title = Yii::t('robote13/catalog', 'Update product: {product}', ['product' => $model->title]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('robote13/catalog', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
