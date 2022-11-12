<?php

use icms\FomanticUI\modules\Checkbox;

// $options = [
//     'labelOptions' => isset($labelOptions) ? $labelOptions : [],
//     'inputOptions' => ['data' => ['name' => $attribute]],
//     'options' => [
//         'style' => 'vertical-align: text-top'
//     ]
// ];

// if (isset($form)) :
//     $field = $form->field($model, $attribute, $options)->checkbox();
// else :
    $field = Checkbox::widget([
        'model' => $model,
        'attribute' => $attribute,
        'labelOptions' => isset($labelOptions) ? $labelOptions : [],
        'inputOptions' => ['data' => ['name' => $attribute]],
        'options' => [
            'style' => 'vertical-align: text-top'
        ]
    ]);
// endif;

echo $field;