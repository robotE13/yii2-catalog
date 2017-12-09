<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use robote13\catalog\models\ProductType;
use robote13\catalog\models\MeasurementUnit;
use vova07\fileapi\Widget;
use vova07\imperavi\Widget as Redactor;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model robote13\catalog\models\Product */
/* @var $module robote13\catalog\Module */
/* @var $leftovers robote13\catalog\models\Leftover[] */

/*$this->registerJs('$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});', yii\web\View::POS_READY);*/

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

<div class="product-form">

    <?php $form = ActiveForm::begin([
        'id'=>'create-product-form'
    ]); ?>
        <h3><?= Yii::t('robote13/catalog', 'Description')?></h3>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <div class="row">
                <?= $form->field($model, 'price',['options'=>['class'=>'form-group col-sm-6']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'measurement_unit_id',['options'=>['class'=>'form-group col-sm-6']])->dropDownList(MeasurementUnit::dropdownItems('id','title')) ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <?= $form->field($model, 'status',['options'=>['class'=>'form-group col-md-6']])->dropDownList($model->getStatuses()) ?>
                <?= $form->field($model, 'vendor_code',['options'=>['class'=>'form-group col-sm-6']])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'origin_country',['options'=>['class'=>'form-group col-sm-6']])->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <?php if($this->context->module->enableBadge):?>
        <?= $form->field($model, 'badge')->widget(Widget::className(),[
            'fileapi'=>$this->context->module->fileapiComponent,
            'settings' => [
                'url' => ['product/fileapi-upload'],
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
                'maxSize' => [750, 600],
                'minSize' => [$module->getCropDimension('width'), $module->getCropDimension('width')],
                'keySupport' => false, // Important param to hide jCrop radio button.
                'selection' => '100%'
            ]
        ]);?>
    <?php endif;?>

    <?= $form->field($model, 'short_description')->textInput();?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6])->widget(Redactor::className(),['settings'=>$redactorSettings]);?>

        <?php foreach ($model->characteristics as $characteristic) :
            echo $characteristic->field($form,$attributes);
        endforeach;

    ?>

    <h3><?= Yii::t('robote13/catalog', 'Leftovers')?></h3>
    <?=yii\grid\GridView::widget([
        'dataProvider'=>new \yii\data\ArrayDataProvider(['allModels'=>$model->leftovers,'pagination'=>false]),
        'layout'=>"{items}",
        'columns'=>[
            'warehouse.title',
            'left_in_stock',
            'reserved'
        ]
    ])?>

    <h3><?= Yii::t('robote13/catalog', 'Related products')?></h3>
    <?= yii\widgets\ListView::widget([
        'dataProvider'=>new \yii\data\ArrayDataProvider(['allModels'=>$model->related]),
        'layout'=>"{items}",
        'options'=>['tag'=>'ul','class'=>'list-group'],
        'itemView'=>function($model){return $model->title . Html::a("&nbsp;<i class='glyphicon glyphicon-new-window'></i>",['update','id'=>$model->id],['target'=>'_blank']);},
        'itemOptions'=>['tag'=>'li','class'=>'list-group-item']
    ])?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('robote13/catalog', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
