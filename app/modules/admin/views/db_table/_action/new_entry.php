<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'new-entry') ? 'primary' : null;
echo Html::a(
    Yii::t('app', 'New entry'),
    [
        'new-entry',
        'SCHEMA_NAME' => Yii::$app->request->getQueryParam('SCHEMA_NAME'),
        'TABLE_NAME' => Yii::$app->request->getQueryParam('TABLE_NAME')
    ],
    ['class' => "compact small basic {$isActive} ui button"]);