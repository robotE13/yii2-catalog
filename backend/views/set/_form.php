<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use vova07\fileapi\Widget;
use vova07\imperavi\Widget as Redactor;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $module robote13\catalog\Module */
/* @var $model robote13\catalog\models\Set */

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

$module = $this->context->module;
$cropAspectRatio = $module->getCropDimension('width')/$module->getCropDimension('height');
?>

<div class="set-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'productsIds')->widget(Select2::className(),[
        'theme' => Select2::THEME_BOOTSTRAP,
        'options'=>[
            'placeholder' => Yii::t('robote13/catalog','Select related ...'),
            'multiple'=>true
        ],
        'initValueText' => ArrayHelper::map($model->products, 'id',function($model){return "{$model->vendor_code} {$model->title}";}),
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'ajax' => [
                'url' => Url::to(['related/products-list']),
                'method'=>'POST',
                'dataType' => 'json',
                'data' => new JsExpression("function(params) {return {q:params.term};}")
            ],
            'templateResult' => new JsExpression("function (product) { return product.title===undefined?product.text:product.vendor_code +' ' + product.title; }"),
            'templateSelection' => new JsExpression("function (product) {return product.title===''?product.text:product.vendor_code +' ' + product.title; }")
        ]
    ])?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?php if($this->context->module->enableBadge):?>
        <?= $form->field($model, 'badge')->widget(Widget::className(),[
                'fileapi'=>$this->context->module->fileapiComponent,
                'settings' => [
                    'url' => ['main/fileapi-upload'],
                    'accept'=>'image/*',
                    'elements'=>[
                        'preview' => [
                            'width' => 125,
                            'height' => 125/$cropAspectRatio
                        ],
                    ]
                ],
                'crop'=>true,
                'jcropSettings'=>[
                    'aspectRatio' => $cropAspectRatio,
                    'bgColor' => '#ffffff',
                    'maxSize' => [800, 600],
                    'minSize' => [$module->getCropDimension('width'), $module->getCropDimension('width')],
                    'keySupport' => false, // Important param to hide jCrop radio button.
                    'selection' => '100%'
                ]
            ]);?>
    <?php endif;?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatuses())?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->widget(Redactor::className(),['settings'=>$redactorSettings]);?>

    <?= $form->field($model, 'discount_amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('robote13/catalog', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
