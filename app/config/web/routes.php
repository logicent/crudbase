<?php

// use yii\web\GroupUrlRule;

// new GroupUrlRule([
//     'prefix' => 'app',
//     'rules' => [
//         'main' => 'main',
//         'setup' => 'setup',
//         'website' => 'website',
//     ],
// ]),
return [
    // ** app routes
    // 'app' => 'admin/admin/index', // defaultRoute requires this rule
    'app/login' => 'admin/admin/login',
    'app/logout' => 'admin/admin/logout',

    // 'app/home' => '/main/home/index',
    // To be moved
    'app/db-list' => '/admin/db-list/index',
    'app/db-table' => '/admin/db-table/index',
    'app/db-view' => '/admin/db-view/index',
    'app/db-cmd' => '/admin/db-cmd/index',
    'app/db-import' => '/admin/db-import/index',
    'app/db-export' => '/admin/db-export/index',

    // ** app modules, std modules
    'app/<module>' => '/<module>',

    // Generic view-specific (generic) routes
    'app/<module>/<controller>' => '<module>/<controller>/index',
    // ***end app
];
