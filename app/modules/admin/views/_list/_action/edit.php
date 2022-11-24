<?php

use icms\FomanticUI\Elements;
use yii\helpers\Html;

return [
    [
        // 'header' => 'Edit',
        'format' => 'raw',
        'value' => function ($model) {
            return Html::a(
                // Yii::t('app', 'edit'),
                Elements::icon('edit outline'),
                false, [
                    'class' => 'text-muted',
                    'style' => 'font-weight: normal;'
                ]);
        },
        'contentOptions' => ['style' => 'width: 17px;']
    ],
];