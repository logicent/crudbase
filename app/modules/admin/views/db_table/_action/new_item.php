<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'new-item') ? 'primary' : null;
echo Html::a(Yii::t('app', 'New item'), ['new-item'], ['class' => "compact small basic {$isActive} ui button"]);