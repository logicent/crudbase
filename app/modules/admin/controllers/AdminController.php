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
        if (Yii::$app->user->isGuest)
            return $this->redirect(['login']);
        // else
        return $this->render('index');
    }

    public function actionLogin()
    {
        $this->layout = '@appMain/views/_layouts/site';

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

                return $this->redirect(['/app/db-list']); // return $this->goBack();}
            }

        $model->password = ''; // clear the password

        return $this->render('auth', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        // Yii::$app->cache->flush(); // Clear all cache here
        Yii::$app->user->logout();

        return $this->goHome();
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