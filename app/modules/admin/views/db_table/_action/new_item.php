<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'create') ? 'primary' : null;
echo Html::a(Yii::t('app', 'New item'), ['create'], ['class' => "compact small basic {$isActive} ui button"]);