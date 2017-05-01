<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\RelatedProduct */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(
    '$("document").ready(function(){
        $("#new-record").on("pjax:end", function() {
            $.pjax.reload({container:"#view-index"});  //Reload GridView
        });
    });'
);
?>

<div class="related-product-form">
    <?php Pjax::begin(['id'=>'new-record']); ?>
        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]); ?>

            <?= $form->field($model, 'related_id')->widget(Select2::className(),[
                'theme' => Select2::THEME_BOOTSTRAP,
                'options'=>[
                    'placeholder' => Yii::t('robote13/catalog','Select related ...'),
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'ajax' => [
                        'url' => Url::to(['products-list']),
                        'method'=>'POST',
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term};}')
                    ],
                    'templateResult' => new JsExpression("function (product) { return product.title===undefined?product.text:product.vendor_code +' ' + product.title; }"),
                    'templateSelection' => new JsExpression("function (product) { return product.title===undefined?product.text:product.vendor_code +' ' + product.title; }")
                ]
            ])?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('robote13/catalog', 'Link'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end();?>
    <?php Pjax::end();?>
</div>
