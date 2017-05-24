<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use robote13\catalog\models\Warehouse;
use robote13\catalog\models\Category;
use robote13\catalog\models\ProductType;
use robote13\catalog\models\MeasurementUnit;
use vova07\fileapi\Widget;
use wbraganca\dynamicform\DynamicFormWidget;
use vova07\imperavi\Widget as Redactor;

/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\Product */
/* @var $form yii\widgets\ActiveForm */
/* @var $leftovers robote13\catalog\models\Leftover[] */

$this->registerJs('$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});', yii\web\View::POS_READY);

$redactorSettings = [
    'lang'=>'ru',
    'minHeight' => 200,
    'maxHeight' => 200,
    'plugins' => [
        'clips',
        'fullscreen',
    ],
    'buttons' => ['html', 'formatting', 'bold', 'italic','underline' ,'deleted',
        'unorderedlist', 'orderedlist', 'outdent', 'indent',
        'link', 'alignment', 'horizontalrule'],
    'buttonSource' => true,
    'formattingAdd'=>[
        'text-info'=>[
            'title'=>'Attention',
            'tag'=>'p',
            'type'=>'block',
            'class'=>'text-alert'
        ]
    ],
    'replaceDivs' =>true
];
?>

<div class="product-form">

    <?php $form = ActiveForm::begin([
        'id'=>'create-product-form'
    ]); ?>
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

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->widget(Redactor::className(),['settings'=>$redactorSettings]) ?>
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item-leftover', // required: css class
            'min' => 1, // 0 or 1 (default 1)
            'limit' => 99, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $leftovers[0],
            'formId' => 'create-product-form',
            'formFields' => ['warehouse_id','left_in_stock']
        ])?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title pull-left"><?= Yii::t('robote13/catalog', 'Leftovers')?></h4>
                <button type="button" class="add-item btn btn-success btn-xs pull-right">Еще склад</button>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <?=$form->errorSummary($leftovers)?>
                    <div class="container-items row">
                        <?php    foreach ($leftovers as $key => $leftover):?>
                        <div class="item-leftover col-lg-6 row">
                            <?=$form->field($leftover, "[{$key}]warehouse_id",['options'=>['class'=>'form-group col-xs-7']])->dropDownList(Warehouse::dropdownItems('id', 'title'))?>
                            <?=$form->field($leftover, "[{$key}]left_in_stock",['options'=>['class'=>'form-group col-xs-3']])?>
                            <div class="col-xs-2 text-center"><button type="button" class="remove-item btn btn-danger btn-xs">Убрать</button></div>
                        </div>
                        <?php                endforeach;?>
                    </div>
            </div>
        </div>
        <?php DynamicFormWidget::end()?>
            <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title pull-left"><?= Yii::t('robote13/catalog', 'Related products')?></h4>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">

            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('robote13/catalog', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
