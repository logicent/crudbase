<?php

use yii\helpers\Html;
use yii\helpers\Url;

$isActive = str_contains(Url::current(), 'alter') ? 'primary' : null;
echo Html::a(Yii::t('app', 'Alter table'), ['alter'], ['class' => "compact small basic {$isActive} ui button"]);