<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\Category */

$this->title = Yii::t('robote13/catalog', 'Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('robote13/catalog', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
