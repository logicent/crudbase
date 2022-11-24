<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'status') ? 'primary' : null;
echo Html::a(Yii::t('app', 'Status'), ['status'], ['class' => "compact small basic {$isActive} ui button"]);