<?php

$context = $this->context;
$model = isset($model) ? $model : $context->model;
?>

<?= $this->render('/_view/_breadcrumb') ?>

<div class="<?= $this->context->id ?>-<?= $this->context->action->id ?>">
    <?= $this->render('_form', [
            'model' => $model,
            'viewPath' => $viewPath,
        ]) ?>
</div>