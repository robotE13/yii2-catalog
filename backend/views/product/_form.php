<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use robote13\catalog\models\Category;
use robote13\catalog\models\ProductType;
use robote13\catalog\models\MeasurementUnit;
use vova07\fileapi\Widget;

/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'type_id')->dropDownList(ProductType::dropdownItems('id','title')) ?>
            <?= $form->field($model, 'badge')->widget(Widget::className(),[
                'settings' => [
                    'url' => ['main/fileapi-upload'],
                    'accept'=>'image/*',
                    'elements'=>[
                        'preview' => [
                            'width' => 140,
                            'height' => 200
                        ],
                    ]
                ],
                'crop'=>true,
                'jcropSettings'=>[
                    'aspectRatio' => 0.7,
                    'bgColor' => '#ffffff',
                    'maxSize' => [500, 600],
                    'minSize' => [280, 400],
                    'keySupport' => false, // Important param to hide jCrop radio button.
                    'selection' => '100%'
                ]
            ]);?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'categoriesIds')->dropDownList(Category::dropdownItems('id','title'),['multiple'=>true,'size'=>5]) ?>
            <div class="row">
                <?= $form->field($model, 'measurement_unit_id',['options'=>['class'=>'form-group col-sm-4']])->dropDownList(MeasurementUnit::dropdownItems('id','title')) ?>
                <?= $form->field($model, 'vendor_code',['options'=>['class'=>'form-group col-sm-4']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'origin_country',['options'=>['class'=>'form-group col-sm-4']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'price',['options'=>['class'=>'form-group col-sm-4']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'status',['options'=>['class'=>'form-group col-sm-4']])->dropDownList($model->getStatuses()) ?>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('robote13/catalog', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
