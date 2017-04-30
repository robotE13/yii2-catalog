<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

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

			<?= $form->field($model, 'related_id')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('robote13/catalog', 'Create') : Yii::t('robote13/catalog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end();?>
    <?php Pjax::end();?>
</div>
