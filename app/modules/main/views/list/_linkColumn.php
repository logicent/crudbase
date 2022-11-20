<?php

use crudle\app\setup\enums\Type_Permission;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Url;

return [
    [
        'attribute' => $searchModel->listSettings->listNameAttribute,
        'format' => 'raw',
        'value' => function ($model, $key, $index, $column)
        {
            if (is_array($model)) {
                $searchModelClass = $this->context->searchModelClass();
                $model = new $searchModelClass();
            }
            $attribute = $column->attribute;
            $linkId = $model->listSettings->listIdAttribute;
            $route = '/app' . '/' . $this->context->listRouteId();

            $linkColumn = Html::a( $model->$attribute,
                                Url::to([$route, $linkId => $model->{$linkId}]),
                                [
                                    'style' => 'font-weight: 500',
                                    'data' => [
                                        'pjax' => '0'
                                    ]
                                ]);
            return $linkColumn;
            // return
            //     Html::tag('div',
            //         Html::tag('div',
            //             $linkColumn,
            //             ['class' => 'twelve wide column']
            //         ) .
            //         Html::tag('div',
            //                 $model->listSettings->listIdAttribute === false ? null : $model->{$model->listSettings->listIdAttribute},
            //                 [
            //                     'class' => 'right aligned four wide column text-muted',
            //                     'style' => 'font-size: 97.5%; font-weight: 500'
            //                 ]
            //             ),
            //         ['class' => 'ui two column stackable grid']
            //     );
        },
        'contentOptions' => [
            'style' => 'white-space: normal; width: 33%',
        ],
    ]
];