<?php

use icms\FomanticUI\widgets\ActiveForm;

$this->title = Yii::t('app', 'Import');
echo $this->render('/_view/_breadcrumb');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Import')];

$fieldOptions = [
    'options' => ['class' => 'inline field'],
    'labelOptions' => ['style' => 'font-size: 16px; font-weight: normal; width: 160px;'],
    'inputOptions' => ['style' => 'font-size: 16px; width: 330px;']
];
?>

<div class="ui segment">
<?php
$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableClientValidation' => false,
    'options' => [
        'autocomplete' => 'off',
        'class' => 'ui form',
        'enctype' => 'multipart/form-data'
    ],
]);
    echo $this->render('@appMain/views/_form_field/file_input_file', [
        'model' => $model,
        'attribute' => $model->fileAttribute,
        'fileType' => $model->fileType,
        'placeholder' => 'SQL[.gz] (< 24MB):'
    ]);

    echo $this->render('@appMain/views/_form_field/checkbox', [
        'model' => $model,
        'attribute' => 'stopOnError',
        'form' => $form,
    ]);
    echo '&emsp;';
    echo $this->render('@appMain/views/_form_field/checkbox', [
        'model' => $model,
        'attribute' => 'showOnlyErrors',
        'form' => $form,
    ]);
ActiveForm::end() ?>
</div>