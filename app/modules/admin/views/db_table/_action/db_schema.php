<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'db/schema') ? 'primary' : null;
echo Html::a(Yii::t('app', 'Database schema'), [
    'db/schema',
    'SCHEMA_NAME' => Yii::$app->request->getQueryParam('SCHEMA_NAME'),
], ['class' => "compact small basic {$isActive} ui button"]);