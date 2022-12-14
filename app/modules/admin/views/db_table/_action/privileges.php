<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'db/privileges') ? 'primary' : null;
echo Html::a(Yii::t('app', 'Privileges'), [
    'db/privileges',
    'SCHEMA_NAME' => Yii::$app->request->getQueryParam('SCHEMA_NAME'),
], ['class' => "compact small basic {$isActive} ui button"]);