<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\models\DbTable;
use crudle\app\admin\models\search\DbTableSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;

class DbController extends DbObjectController
{
    public function actions()
    {
        return [
            // 'index' => Index::class,
            // 'create' => Create::class,
            // 'alter' => Alter::class,
            // 'drop' => Drop::class,
        ];
    }

    public function modelClass(): string
    {
        return DbTable::class;
    }

    public function searchModelClass(): string
    {
        return DbTableSearch::class;
    }

    public function actionIndex()
    {
        $searchModelClass = $this->searchModelClass();
        $searchModel = new $searchModelClass;
        // $searchClassname = StringHelper::basename($searchModelClass);

        // check if global search is used to fetch result
        // if (!empty(Yii::$app->request->get('GlobalSearch')))
        // {
        //     $globalSearchTerm = [
        //         $searchClassname => [
        //             $searchModel->listSettings->listNameAttribute => Yii::$app->request->get('GlobalSearch')['gs_term'],
        //         ],
        //     ];
        //     $userFilters = $globalSearchTerm;
        // }
        // check if get is called via Ajax or HX-Request
        $filterColumnName = 'SCHEMA_NAME';
        $headers = Yii::$app->request->headers;
        $isAjaxRequest = Yii::$app->request->isAjax || $headers->has('HX-Request');
        if ($isAjaxRequest)
            $userFilters = [$filterColumnName => Yii::$app->request->get('DatabaseForm')['schemaName']];
        else // called via browser URL
            $userFilters = Yii::$app->request->queryParams;

        if (!empty($userFilters)) // only fetch if filter params exist
            $dataProvider = $searchModel->search($userFilters);
        else {
            $dataProvider = new ActiveDataProvider([
                'query' => $this->modelClass()::find()->where(['TABLE_SCHEMA' => ''])
            ]);
        }

        $formModelClass = $this->formModelClass();
        $this->formModel = new $formModelClass;
        $this->formModel->schemaName = isset($userFilters[$filterColumnName]) ? $userFilters[$filterColumnName] : null;

        $data = [
            'formModel' => $this->formModel,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
        $view = 'index';
        if ($isAjaxRequest) // renderAjax
            return $this->render($view, $data);
        else
            return $this->render($view, $data);
    }

    // public function actionServer()
    // {}

    public function actionCollation()
    {}

    public function actionEngine()
    {}

    public function actionCharacterSet()
    {}

    public function actionCreate()
    {
        $modelClass = $this->formModelClass(); 
        $this->formModel = new $modelClass;

        if ($this->formModel->load(Yii::$app->request->post()) && $this->formModel->validate()) {
            try {
                Yii::$app->db->createCommand('CREATE DATABASE ' . $this->formModel->schemaName)->execute();
                return $this->redirect(['index']);
            } catch (\yii\db\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('/_form/index');
    }

    // Rename ?
    public function actionAlter()
    {}

    public function actionDrop()
    {}

    // ViewInterface
    public function mainAction()
    {
    }

    public function viewActions(): array
    {
        return [
            'alter_database',
            'database_schema',
            'privileges',
        ];
    }

    public function menuActions(): array
    {
        return [
            'create_table',
            'create_view',
            'create_event',
            'create_function',
            'create_procedure',
        ];
    }

    public function userActions(): array
    {
        return [];
    }

    // ListViewInterface
    public function listRouteId(): string
    {
        return 'db-table';
    }

    public function batchActionsMenu(): array
    {
        return [
            'analyze',
            'optimize',
            'check',
            'repair',
            'truncate',
            'drop',
            'move',
            'copy',
        ];
    }
}
