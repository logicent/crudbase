<?php

namespace crudle\app\main\controllers;

use crudle\app\admin\models\auth\LoginForm;
use crudle\app\main\controllers\base\BaseViewController;
use crudle\app\main\enums\Type_View;
use Yii;

class HomeController extends BaseViewController
{
    public function actions()
    {
        return [
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->session->has('dbConfig'))
            return $this->redirect(['/app/login']);

        $model = new LoginForm();
        // reconnect to set/default database
        $dbConfig = array_merge(
            Yii::$app->session->get('dbConfig'),
            Yii::$app->session->get('dbInfo')
        );
        $model->attributes = $dbConfig;
        $model->setDbConfig(Yii::$app->session->get('dbConfig'));
        $model->establishConnection();

        return $this->render('index');
    }

    // ViewInterface
    public function defaultActionViewType()
    {
        return Type_View::Workspace;
    }

    public function showViewHeader(): bool
    {
        return false;
    }

    public function showViewSidebar(): bool
    {
        return false;
    }
}
