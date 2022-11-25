<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'db/privileges') ? 'primary' : null;
echo Html::a(Yii::t('app', 'Privileges'), ['privileges'], ['class' => "compact small basic {$isActive} ui button"]);