<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'explain') ? 'primary' : null;
echo Html::a(Yii::t('app', 'Structure'), ['explain'], ['class' => "compact small basic {$isActive} ui button"]);