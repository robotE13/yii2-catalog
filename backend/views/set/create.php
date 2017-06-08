<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\Set */

$this->title = Yii::t('robote13/catalog', 'Create Set');
$this->params['breadcrumbs'][] = ['label' => Yii::t('robote13/catalog', 'Sets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="set-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
