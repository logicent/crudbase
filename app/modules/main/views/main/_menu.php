<?php

use crudle\app\helpers\App;
use crudle\app\main\enums\Type_Menu_Sub_Group;
// use crudle\app\setup\models\DeveloperSettingsForm;
// use crudle\app\setup\models\Setup;
use yii\helpers\Inflector;

$this->params['menuGroupClass'] = Type_Menu_Sub_Group::class;
// $deployedSettings = Setup::getSettings( DeveloperSettingsForm::class );

$modules = App::getModules();
// $workspaces = Workspace::find()->where(['inactive' => false])->all();
$moduleMenus = $workspaceMenus = [];

$workspaceMenus[] = [
    'route' => '/main/home/index',
    'label' => 'Home',
    'group' => '',
    'visible' => true,
];
foreach ($modules::$modules as $id => $module) :
    $moduleName = Inflector::id2camel($module['id']);
    $moduleMenus[] = [
        'route' =>  "/{$module['id']}",
        'label' => $module['name'],
        'group' => '',
        'visible' => true,
    ];
endforeach;

$menus = array_merge($moduleMenus, $workspaceMenus);

return $menus;
