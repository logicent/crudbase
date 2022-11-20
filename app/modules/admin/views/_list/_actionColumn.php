<?php

use icms\FomanticUI\Elements;
use yii\helpers\Html;

return [
    [
        'format' => 'raw',
        'value' => function ($model) {
            return Html::a(Elements::icon('edit outline'), false, [ // Yii::t('app', 'edit')
                'class' => 'text-muted',
                'style' => 'font-weight: normal;'
            ]);
        },
    ],
];