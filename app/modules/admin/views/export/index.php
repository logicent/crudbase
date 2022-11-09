<?php

use crudle\app\admin\enums\Export_Format;
use crudle\app\admin\enums\Export_Output;
use crudle\app\admin\models\DbTable;
use icms\FomanticUI\widgets\ActiveForm;

$this->title = Yii::t('app', 'Export');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Export'), 'url' => ['/app/db-export']];

$fieldOptions = [
    'options' => ['class' => 'inline field'],
    'labelOptions' => ['style' => 'font-size: 16px; font-weight: normal; width: 160px;'],
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
    ],
]);
    echo $this->render('@appMain/views/_form_field/dropdown', [
        'model' => $model,
        'form' => $form,
        'fieldOptions' => $fieldOptions,
        'attribute' => 'database',
        'list' => [
            '' => ' ',
            'use' => 'USE',
            'create' => 'CREATE',
            'drop_create' => 'DROP+CREATE',
        ],
        'htmlOptions' => ['style' => 'font-size: 16px; width: 330px;']
    ]);
    echo $this->render('@appMain/views/_form_field/checkbox', [
        'model' => $model,
        'form' => $form,
        'fieldOptions' => $fieldOptions,
        'attribute' => 'routines',
    ]);
    echo $this->render('@appMain/views/_form_field/checkbox', [
        'model' => $model,
        'form' => $form,
        'fieldOptions' => $fieldOptions,
        'attribute' => 'events',
    ]);
    echo $this->render('@appMain/views/_form_field/dropdown', [
        'model' => $model,
        'form' => $form,
        'fieldOptions' => $fieldOptions,
        'attribute' => 'tables',
        'list' => [
            '' => ' ',
            'create' => 'CREATE',
            'drop_create' => 'DROP+CREATE',
        ],
        'htmlOptions' => ['style' => 'font-size: 16px; width: 330px;']
    ]);
    echo $this->render('@appMain/views/_form_field/checkbox', [
        'model' => $model,
        'form' => $form,
        'fieldOptions' => $fieldOptions,
        'attribute' => 'autoIncrement',
    ]);
    echo $this->render('@appMain/views/_form_field/checkbox', [
        'model' => $model,
        'form' => $form,
        'fieldOptions' => $fieldOptions,
        'attribute' => 'triggers',
    ]);
    echo $this->render('@appMain/views/_form_field/dropdown', [
        'model' => $model,
        'form' => $form,
        'fieldOptions' => $fieldOptions,
        'attribute' => 'data',
        'list' => [
            '' => ' ',
            'insert' => 'INSERT',
            'insert_update' => 'INSERT+UPDATE',
            'truncate_insert' => 'TRUNCATE+INSERT',
        ],
        'htmlOptions' => ['style' => 'font-size: 16px; width: 330px;']
    ]);
    echo $this->render('@appMain/views/_form_field/radio_list', [
        'model' => $model,
        'form' => $form,
        'fieldOptions' => $fieldOptions,
        'attribute' => 'format',
        'items' => Export_Format::enums(),
        'inline' => true,
    ]);
    echo $this->render('@appMain/views/_form_field/radio_list', [
        'model' => $model,
        'form' => $form,
        'fieldOptions' => $fieldOptions,
        'attribute' => 'output',
        'items' => Export_Output::enums(),
        'inline' => true,
    ]);
    // $tables = DbTable::find()->select('TABLE_NAME', 'TABLE_ROWS')->where(['TABLE_SCHEMA' => $model->schemaName])->asArray()->all();
    // foreach ($tables as $index => $table) :
    //     $items[] = [
    //         'url' => ['db-table/select', 'TABLE_NAME' => $table['TABLE_NAME']],
    //         'label' => $table['TABLE_NAME']
    //     ];
    // endforeach;
    // echo Menu::widget([
    //     'id' => 'sidebar_menu',
    //     'items' => $items ?? [],
    //     'options' => [
    //         'class' => 'secondary fluid vertical pointing',
    //     ],
    // ]);
ActiveForm::end() ?>
</div>