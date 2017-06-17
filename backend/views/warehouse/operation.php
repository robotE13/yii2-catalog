<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model robote13\catalog\models\Warehouse */

$this->title = Yii::t('robote13/catalog', '{kind} on the warehouse: "{warehouse}" ', ['kind'=>$operations[0]->typeText,'warehouse' => $model->title]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('robote13/catalog', 'Warehouses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $form = ActiveForm::begin([
    'id'=>'create-operation-form'
])?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title pull-left"><?=$operations[0]->typeText?></h4>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item-leftover', // required: css class
        'min' => 1, // 0 or 1 (default 1)
        'limit' => 99, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $operations[0],
        'formId' => 'create-operation-form',
        'formFields' => ['product_id','quantity']
    ])?>
        <?=$form->errorSummary($operations)?>
            <div class="container-items row">
                <?php    foreach ($operations as $key => $operation):?>
                <div class="item-leftover col-lg-6 row">
                    <?=$form->field($operation, "[{$key}]product_id",['options'=>['class'=>'form-group col-xs-7']])->dropDownList(app\modules\catalog\models\Product::dropdownItems('id', 'title'))?>
                    <?=$form->field($operation, "[{$key}]quantity",['options'=>['class'=>'form-group col-xs-2']])?>
                    <div class="col-xs-3 text-center clearfix">
                        <label class="control-label">&nbsp;</label>
                        <p>
                        <button type="button" class="remove-item btn btn-danger btn-xs pull-left">Убрать</button>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <button type="button" class="add-item btn btn-success btn-xs">Добавить товар</button>
            </div>
    <?php DynamicFormWidget::end()?>
            <div class="form-group">
                <?=Html::submitButton(Yii::t('robote13/catalog','Issue'),['class'=>'btn btn-success'])?>
        </div>
            </div>
        </div>
<?php ActiveForm::end()?>