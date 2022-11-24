<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'select') ? 'primary' : null;
echo Html::a(Yii::t('app', 'Select data'), ['select'], ['class' => "compact small basic {$isActive} ui button"]);