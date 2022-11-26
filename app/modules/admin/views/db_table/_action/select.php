<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'select') ? 'primary' : null;
echo Html::a(
    Yii::t('app', 'Select data'),
    ['select', 'SCHEMA_NAME' => Yii::$app->request->queryParams['SCHEMA_NAME'], 'TABLE_NAME' => Yii::$app->request->queryParams['TABLE_NAME']],
    ['class' => "compact small basic {$isActive} ui button"]);