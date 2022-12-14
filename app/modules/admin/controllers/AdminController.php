<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\forms\ConnectionMySql;
use crudle\app\main\controllers\base\BaseViewController;
use crudle\app\main\enums\Type_View;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class AdminController extends BaseViewController
{
    public $layout = '@appMain/views/_layouts/site';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'login', 'logout'],
                'rules' => [
                    [
                        'actions' => ['index', 'login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        $model = new ConnectionMySql(); // To-Do: add support for other db

        if ($model->load(Yii::$app->request->post()) && $model->validate())
            // connect to set/default database
            if ($model->establishConnection())
            {
                // persist the db connection properties
                Yii::$app->session->set('dbConfig', $model->getDbConfig());
                $dbInfo = [
                    'host' => $model->useHost(),
                    'database' => $model->useDatabase(),
                ];
                Yii::$app->session->set('dbInfo', $dbInfo);
                if (!empty($model->database))
                    $route = "/admin/db?SCHEMA_NAME={$model->database}";
                else
                    $route = '/admin/db';

                return $this->redirect([$route]);
            }

        $model->password = ''; // clear the password

        return $this->render('auth', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->db->close();
        Yii::$app->session->destroy(); // clear all cached settings

        return $this->redirect(['login']);
    }

    public function defaultActionViewType()
    {
        return Type_View::Workspace;
    }

    public function showViewHeader(): bool
    {
        return false;
    }
}