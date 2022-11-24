<?php

use icms\FomanticUI\widgets\ActiveForm;
use yii\helpers\Inflector;

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
    echo $this->render('_header', ['model' => $model]);
    $viewName = Inflector::underscore(Inflector::id2camel($this->context->action->id));
    echo $this->render($viewPath, [
            'form' => $form,
            'model' => $model
        ]);
ActiveForm::end();

$this->registerJs(<<<JS
    $('.ui.dropdown').dropdown({
        // action: 'hide',
        // onChange: function(value, text, selectedItem) {
        //     console.log(value, text. selectedItem)
        // }
        // clearable : true,
        // values : listOptions, // get values from JS global var of listOptions
        // placeholder : 'Choose',
    });
JS);