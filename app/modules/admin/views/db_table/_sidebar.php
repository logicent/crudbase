<?php

use crudle\app\admin\models\Database;
use crudle\app\admin\models\DbTable;
use icms\FomanticUI\collections\Menu;
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
    $tables = DbTable::find()->where(['TABLE_SCHEMA' => $model->schemaName])->asArray()->all();
    foreach ($tables as $index => $table) :
        $items[] = [
            'url' => ['db-table/select', 'TABLE_NAME' => $table['TABLE_NAME']],
            'label' => $table['TABLE_NAME']
        ];
    endforeach;
    echo Menu::widget([
        'id' => 'sidebar_menu',
        'items' => $items ?? [],
        'options' => [
            'class' => 'secondary fluid vertical pointing',
        ],
    ]);
ActiveForm::end();