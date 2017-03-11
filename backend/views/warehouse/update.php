<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\Warehouse */

$this->title = Yii::t('robote13/catalog', 'Update {modelClass}: ', [
    'modelClass' => 'Warehouse',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('robote13/catalog', 'Warehouses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('robote13/catalog', 'Update');
?>
<div class="warehouse-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
