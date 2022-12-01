<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'explain') ? 'primary' : null;
echo Html::a(
    Yii::t('app', 'Structure'),
    [
        'structure',
        'SCHEMA_NAME' => Yii::$app->request->getQueryParam('SCHEMA_NAME'),
        'TABLE_NAME' => Yii::$app->request->getQueryParam('TABLE_NAME')
    ],
    ['class' => "compact small basic {$isActive} ui button"]);