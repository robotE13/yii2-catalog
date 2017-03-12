<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\ProductType */

$this->title = Yii::t('robote13/catalog', 'Create Product Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('robote13/catalog', 'Product Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
