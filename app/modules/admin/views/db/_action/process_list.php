<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'process-list') ? 'primary' : null;
echo Html::a(Yii::t('app', 'Process list'), ['process-list'], ['class' => "compact small basic {$isActive} ui button"]);