<?php

use icms\FomanticUI\Elements;
use yii\helpers\Html;

return [
    [
        // 'header' => 'Edit',
        'format' => 'raw',
        'value' => function ($model) {
            $user = Yii::$app->request->getQueryParam('user');
            $host = Yii::$app->request->getQueryParam('host');

            return Html::a(// Yii::t('app', 'edit'),
                Elements::icon('edit outline'),
                ['edit',
                    'user' => $user,
                    'host' => $host,
                ],
                [
                    'class' => 'text-muted',
                    'style' => 'font-weight: normal;'
                ]);
        },
        'contentOptions' => ['style' => 'width: 17px;']
    ],
];