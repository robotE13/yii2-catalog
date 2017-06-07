<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\Product */

$this->title = Yii::t('robote13/catalog', 'Create Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('robote13/catalog', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
