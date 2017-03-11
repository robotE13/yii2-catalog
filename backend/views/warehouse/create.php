<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\Warehouse */

$this->title = Yii::t('robote13/catalog', 'Create Warehouse');
$this->params['breadcrumbs'][] = ['label' => Yii::t('robote13/catalog', 'Warehouses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="warehouse-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
