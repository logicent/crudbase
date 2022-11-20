<?php

namespace crudle\app\admin\controllers;

use crudle\app\main\controllers\base\BaseViewController;
use crudle\app\main\enums\Type_View;
use crudle\app\admin\models\auth\LoginForm;
use Yii;
use yii\helpers\Html;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

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
        $model = new LoginForm();

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
                    $route = "db?SCHEMA_NAME={$model->database}";
                else
                    $route = 'server';
                return $this->redirect(["/app/$route"]);
            }

        $model->password = ''; // clear the password

        return $this->render('auth', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {exit;
        Yii::$app->session->destroy(); // clear all cached settings
        Yii::$app->app->db->close();

        return $this->redirect(['/app/login']);
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