<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\MeasurementUnit */

$this->title = Yii::t('robote13/catalog', 'Create Measurement Unit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('robote13/catalog', 'Measurement Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="measurement-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
