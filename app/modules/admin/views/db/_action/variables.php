<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'variables') ? 'primary' : null;
echo Html::a(Yii::t('app', 'Variables'), ['variables'], ['class' => "compact small basic {$isActive} ui button"]);