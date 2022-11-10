<?php

$context = $this->context;
$model = $context->model;

// $actionTitle = $this->context->action->id;
// $this->title = Yii::t('app', '{formTitle}', ['formTitle' => $actionTitle . $context->viewName()]);
?>

<?= $this->render('/_view/_breadcrumb') ?>

<div class="<?= $this->context->id ?>-<?= $this->context->action->id ?>">
    <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
</div>