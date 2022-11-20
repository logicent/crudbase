<?php

use yii\db\Expression;

return [
    [
        'attribute' => 'DEFAULT_COLLATION_NAME',
    ],
    [
        'attribute' => 'tables',
        'headerOptions' => [
            'class' => 'list-header computed-stat right aligned'
        ],
        'value' => function ($model) {
            return $model->getDbTable()->count();
        },
        'contentOptions' => [
            'class' => 'right aligned'
        ]
    ],
    [
        'attribute' => 'size',
        'headerOptions' => [
            'class' => 'list-header computed-stat right aligned'
        ],
        'format' => 'integer',
        'value' => function ($model) {
            return $model->getDbTable()->sum(new Expression('DATA_LENGTH + INDEX_LENGTH'));
        },
        'contentOptions' => [
            'class' => 'right aligned'
        ]
    ],
];