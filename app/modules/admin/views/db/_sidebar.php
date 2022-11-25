<?php

use crudle\app\admin\models\Database;
use icms\FomanticUI\widgets\ActiveForm;
use yii\helpers\Url;

$model = $this->context->formModel;

$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableClientValidation' => false,
    'options' => [
        'autocomplete' => 'off',
        'class' => 'ui form',
    ],
]);
    echo $this->render('@appMain/views/_form_field/select', [
        'model' => $model,
        'form' => $form,
        'attribute' => 'schemaName',
        'list' => [
            'modelClass' => Database::class,
            'keyAttribute' => 'SCHEMA_NAME',
            'valueAttribute' => 'SCHEMA_NAME',
            'addEmptyFirstItem' => true,
            'filters' => []
        ],
        'options' => [
            'onclick' => <<<JS
                console.log($(this).val());
            JS,
            'data' => [
                'hx-get' => Url::to(['db-table/index', 'SCHEMA_NAME' => '']),
                'hx-target' => 'body > div.main', // #content
                'hx-push-url' => 'true',
                'hx-swap' => 'outerHTML'
            ]
        ]
    ]);
ActiveForm::end();