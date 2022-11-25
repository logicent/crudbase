<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'db/db-schema') ? 'primary' : null;
echo Html::a(Yii::t('app', 'Database schema'), ['db-schema'], ['class' => "compact small basic {$isActive} ui button"]);