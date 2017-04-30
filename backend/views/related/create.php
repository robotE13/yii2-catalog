<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\RelatedProduct */

$this->title = Yii::t('robote13/catalog', 'Create Related Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('robote13/catalog', 'Related Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="related-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
