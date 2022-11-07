<?php

use crudle\app\helpers\App;
use yii\db\Connection;
use yii\helpers\ArrayHelper;

$coreModules = [
    // core modules
    'main'  => crudle\app\main\Module::class,
    'admin'  => crudle\app\admin\Module::class,
];

// user modules
$userModules = App::getModules();
$userModules = ArrayHelper::map($userModules::$modules, 'id', 'class');
// set modules tablePrefix
return ArrayHelper::merge($coreModules, $userModules);
