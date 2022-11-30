<?php

use icms\FomanticUI\modules\Checkbox;
use yii\helpers\Html;

$formSection = '';
$beginFormSection = 
    Html::beginTag('div', ['class' => 'ui padded segment']) .
    Html::beginTag('div', ['class' => 'ui one column stackable grid']);
$endFormSection = 
    Html::endTag('div') . // ui two column stackable grid
    Html::endTag('div'); // ui padded segment
$beginLeftColumn = Html::beginTag('div', ['class' => 'column']);
$endLeftColumn = Html::endTag('div'); // column
$formSection = $beginFormSection . $beginLeftColumn;

$formSection .= Html::hiddenInput('SCHEMA_NAME', $tableDef->schemaName);
$formSection .= Html::hiddenInput('TABLE_NAME', $tableDef->name);
$formSection .= Html::hiddenInput('TABLE_ID', $model->{$tableDef->primaryKey[0]});

$inputOptions = ['style' => 'font-size: 16px; width: 400px;'];

foreach ($tableDef->columns as $attribute => $columnSchema) :
    $columnName = $columnSchema->name;
    $columnValue = $model->{$columnName};
    $inputOptions = array_merge($inputOptions, ['value' => $columnValue]);
    switch ($columnSchema->type) :
        case 'integer':
            $input = Html::activeTextInput($model, $columnName, $inputOptions);
            break;
        case 'date':
            // datepicker
            $input = Html::activeTextInput($model, $columnName, $inputOptions);
            break;
        case 'datetime':
            // datetimepicker
            $input = Html::activeTextInput($model, $columnName, $inputOptions);
            break;
        case 'tinyint':
            $input = Checkbox::widget([
                'model' => $model,
                'attribute' => $columnSchema->name,
                'inputOptions' => $inputOptions
            ]);
            break;
        case 'text':
            $input = Html::activeTextarea($model, $columnName, $inputOptions);
            break;
        case 'decimal':
            $input = Html::activeTextInput($model, $columnName, $inputOptions);
            break;
        case 'json':
            $input = Html::activeTextarea($model, $columnName, $inputOptions);
            break;
        case 'char':
        case 'string':
        default:
            $input = Html::activeTextInput($model, $columnName, $inputOptions);
    endswitch;

    $label = Html::label(
        $model->getAttributeLabel($columnSchema->name),
        $columnSchema->name,
        ['style' => 'font-size: 14px; font-weight: normal; width: 200px;'] // text-align: right;
    );
    $field = Html::beginTag('div', ['class' => 'inline field'])
            . $label
            . $input
            . Html::endTag('div');
    $formSection .= $field;
endforeach;

$formSection .= $endLeftColumn . $endFormSection;
echo $formSection;