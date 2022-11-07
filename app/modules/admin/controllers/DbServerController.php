<?php

namespace crudle\app\admin\controllers;

use crudle\app\main\controllers\base\BaseViewController;
use crudle\app\main\enums\Type_View;
use Yii;

class DbServerController extends BaseViewController
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
        // fetch the list of all databases
        $hasDbConfig = Yii::$app->session->has('dbConfig');
        if (!$hasDbConfig) {
            return $this->redirect(['/app/login']);
        }
        // $session['database'] = 'information_schema';
        // $session['dsn'] = "{$session['driver']}:host={$session['host']};dbname={$session['database']}";
        $databases = Yii::$app->db->createCommand(<<<SQL
        SELECT DISTINCT `TABLE_SCHEMA`
        FROM `TABLES`
        WHERE `TABLE_SCHEMA` <> "information_schema"
            AND  `TABLE_SCHEMA` <> "information_schema"
            AND  `TABLE_SCHEMA` <> "mysql"
            AND  `TABLE_SCHEMA` <> "performance_schema"
            AND  `TABLE_SCHEMA` <> "sys"
        SQL)->queryAll();

        $dbTables = [];
        foreach ($databases as $id => $db) {
            $dbName = $db['TABLE_SCHEMA'];
            $dbTables[$dbName] = Yii::$app->db->createCommand(<<<SQL
                SELECT * 
                FROM `TABLES` 
                WHERE `TABLE_SCHEMA` = '$dbName'
            SQL)->queryAll();
            break;
        }

        return $this->render('index', ['databases' => $databases]);
    }

    /**
     * Renders the create view for the controller
     * @return string
     */
    public function actionCreate()
    {
        return $this->render('create');
    }

    /**
     * Renders the alter view for the controller
     * @return string
     */
    public function actionAlter()
    {
        return $this->render('alter');
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
