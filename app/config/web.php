<?php

use crudle\app\helpers\App;
use crudle\app\main\models\auth\User;

$params = require __DIR__ . '/params.php';
// $db = require __DIR__ . '/db.php';
$routes = require __DIR__ . '/web/routes.php';
$modules = require __DIR__ . '/modules.php';

$config = [
    'id' => 'crudbase-web',
    'name' => App::env('CRUDLE_APP_NAME'),
    'runtimePath' => '@storage/runtime',
    'vendorPath' => '@crudle/vendor',
    'basePath' => dirname( __DIR__ ),
    'layoutPath' =>  '@appMain/views/_layouts',

    'bootstrap' => ['log'],

    'timeZone' => 'Africa/Nairobi',
    'defaultRoute' => '/admin/admin/index',

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'request' => [
            // !!! secret key - this is required by cookie validation
            'cookieValidationKey' => 'ohr2Bs_O7Dopc_LcWy3BMv7BiZOZ5fpe',
            // Let the API accept input data in JSON format
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'user' => [
            'identityClass' => User::class,
            // 'loginUrl' => '/admin/admin/login'
        ],
        'errorHandler' => [
            'errorAction' => '/admin/admin/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            // 'enableStrictParsing' => true,
            'showScriptName' => (bool) App::env('CRUDLE_SHOW_SCRIPT_NAME'),
            'rules' => $routes,
        ],
        'formatter' => [
            'defaultTimeZone' => 'Africa/Nairobi',
            'nullDisplay' => '<span class="not-set">NULL</span>',
        ],
    ],
    'modules' => $modules,
    'params' => $params,
];

// dynamically append rules via Module bootstrap($app)
foreach ($modules as $id => $class) {
    $config['bootstrap'][] = $id;
}

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['192.168.*.*', '172.16.*.*', '10.*.*.*', '127.0.0.1', '::1'],
    ];
}

return $config;
