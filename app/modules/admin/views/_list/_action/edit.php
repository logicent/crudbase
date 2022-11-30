<?php

use icms\FomanticUI\Elements;
use yii\helpers\Html;

return [
    [
        // 'header' => 'Edit',
        'format' => 'raw',
        'value' => function ($model) {
            $tableSchema = Yii::$app->request->getQueryParam('SCHEMA_NAME');
            $tableName = Yii::$app->request->getQueryParam('TABLE_NAME');
            $tableId = $model[$this->params['tablePK'][0]];

            return Html::a(// Yii::t('app', 'edit'),
                Elements::icon('edit outline'),
                ['edit',
                    'SCHEMA_NAME' => $tableSchema,
                    'TABLE_NAME' => $tableName,
                    'TABLE_ID' => $tableId,
                ],
                [
                    'class' => 'text-muted',
                    'style' => 'font-weight: normal;'
                ]);
        },
        'contentOptions' => ['style' => 'width: 17px;']
    ],
];