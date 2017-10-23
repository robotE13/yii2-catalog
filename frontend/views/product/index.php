<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $searchModel \robote13\catalog\forms\ProductSearch */
/* @var $model robote13\catalog\models\Product */

?>
<div class="shop-catalog-default-index">
    <h1><?= $searchModel->productKind ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <?=yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => function($model){
            return '<section>'
                . Html::tag('h2', $model->title)
                . $model->description
                . Html::a(Yii::t('robote13/catalog','Details'),['product/view','productKind'=>$model->type->kind,'id'=>$model->slug])
                . '<section>';
            }
    ])?>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>
