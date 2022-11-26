<?php

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

foreach ($model->columns as $attribute => $columnSchema) :
    switch ($columnSchema->type) :
        // case 'int':
    //         break;
        // case 'date':
    //         break;
        // case 'datetime':
    //         break;
        // case 'boolean': // tinyint
    //         break;
        // case 'text':
    //         break;
        // case 'decimal'
    //         break;
        default:
            $label = Html::label(
                $model->getAttributeLabel($columnSchema->name),
                $columnSchema->name,
                ['style' => 'font-size: 14px; font-weight: normal; width: 200px;'] // text-align: right;
            );
            $input = Html::textInput($columnSchema->name, '', ['style' => 'font-size: 16px; width: 400px;']);
    endswitch;

    $field = Html::beginTag('div', ['class' => 'inline field'])
            . $label
            . $input
            . Html::endTag('div');
    $formSection .= $field;
endforeach;

$formSection .= $endLeftColumn . $endFormSection;
echo $formSection;