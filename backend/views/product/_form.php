<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use robote13\catalog\models\ProductType;
use robote13\catalog\models\MeasurementUnit;

/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type_id')->dropDownList(ProductType::dropdownItems('id','title')) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'measurement_unit_id')->dropDownList(MeasurementUnit::dropdownItems('id','title')) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatuses()) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('robote13/catalog', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
