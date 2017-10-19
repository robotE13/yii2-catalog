<?php

use yii\helpers\Html;

/* @var $model robote13\catalog\models\Product */
/* @var $this yii\web\View */

?>

<article class="catalog-product-view">
    <?= Html::tag('h1', $model->title)?>
    <?= $model->description ?>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</article>