<?php

use icms\FomanticUI\widgets\ActiveForm;

echo $this->render('/_view/_breadcrumb');
$this->params['breadcrumbs'][] = ['label' => $tableDef->schemaName];

$hintOptions = [
    'tag' => 'div',
    'class' => 'text-muted',
    'style' => 'font-size: 0.95em; padding-left: 0.25em'
];
$hasFileInput = isset($model->uploadForm);

$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableClientValidation' => true,
    'fieldConfig' => ['hintOptions' => $hintOptions],
    'options' => [
        'autocomplete' => 'off',
        'class' => 'ui form',
        'enctype' => $hasFileInput ? 'multipart/form-data' : false,
    ],
]);
    echo $this->render('@appMain/views/_form/_header', ['model' => $model]);
    // generate column input fields for specific db object (table or view)
    echo $this->render('_field_inputs', [
        'tableDef' => $tableDef,
        'model' => $model,
        'form' => $form
    ]);
ActiveForm::end();

// additional form view js scripts
$this->registerJs(<<<JS
//  form view javascript
JS);