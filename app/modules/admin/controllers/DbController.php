<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\controllers\base\DbObjectController;
use crudle\app\admin\models\Database;
use crudle\app\admin\models\search\DatabaseSearch;
use Yii;
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
        return Database::class;
    }

    public function searchModelClass(): string
    {
        return DatabaseSearch::class;
    }

    public function actionIndex()
    {
        $searchModelClass = $this->searchModelClass();
        $searchClassname = StringHelper::basename($searchModelClass);
        $searchModel = new $searchModelClass;

        // check if global search is used to fetch result
        if (!empty(Yii::$app->request->get('GlobalSearch')))
        {
            $globalSearchTerm = [
                $searchClassname => [
                    $searchModel->listSettings->listNameAttribute => Yii::$app->request->get('GlobalSearch')['gs_term'],
                ],
            ];
            $userFilters = $globalSearchTerm;
        }
        else
            $userFilters = Yii::$app->request->queryParams;

        $filterColumnName = $searchModel->listSettings->listIdAttribute;
        // if (!empty($userFilters))
        // fetch the list of all (system + user) databases
        $dataProvider = $searchModel->search($userFilters);
        // else {
        //     $dataProvider = new ActiveDataProvider([
        //         'query' => $this->modelClass()::find()->where([$filterColumnName => ''])
        //     ]);
        // }

        $formModelClass = $this->formModelClass();
        $this->formModel = new $formModelClass;
        $this->formModel->schemaName = $userFilters[$filterColumnName] ?? null;

        $data = [
            'formModel' => $this->formModel,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
        $view = 'index';
        if (Yii::$app->request->isAjax)
            return $this->renderAjax($view, $data);
        else
            return $this->render($view, $data);
    }

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

        return $this->render('create');
    }

    public function actionPrivileges()
    {
        $modelClass = $this->formModelClass(); 
        $this->formModel = new $modelClass;

        if ($this->formModel->load(Yii::$app->request->post()) && $this->formModel->validate()) {
            try {
                // Yii::$app->db->createCommand('CREATE USER ' . $this->formModel->schemaName)->execute();
                return $this->redirect(['index']);
            } catch (\yii\db\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('privileges');
    }

    public function actionProcessList()
    {
        $modelClass = $this->formModelClass(); 
        $this->formModel = new $modelClass;

        if ($this->formModel->load(Yii::$app->request->post()) && $this->formModel->validate()) {
            try {
                // Kill selected process(es)
                return $this->redirect(['index']);
            } catch (\yii\db\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('process_list');
    }

    public function actionVariables()
    {
        $modelClass = $this->formModelClass(); 
        $this->formModel = new $modelClass;

        if ($this->formModel->load(Yii::$app->request->post()) && $this->formModel->validate()) {
            // try {
            //     return $this->redirect(['index']);
            // } catch (\yii\db\Exception $e) {
            //     Yii::$app->session->setFlash('error', $e->getMessage());
            // }
        }

        return $this->render('variables');
    }

    public function actionStatus()
    {
        $modelClass = $this->formModelClass(); 
        $this->formModel = new $modelClass;

        if ($this->formModel->load(Yii::$app->request->post()) && $this->formModel->validate()) {
            // try {
            //     return $this->redirect(['index']);
            // } catch (\yii\db\Exception $e) {
            //     Yii::$app->session->setFlash('error', $e->getMessage());
            // }
        }

        return $this->render('status');
    }

    // public function actionServer()
    // {}

    public function actionCollation()
    {}

    public function actionEngine()
    {}

    public function actionCharacterSet()
    {}

    public function actionAlter()
    {
        $modelClass = $this->formModelClass(); 
        $this->formModel = new $modelClass;

        if ($this->formModel->load(Yii::$app->request->post()) && $this->formModel->validate()) {
            try {
                Yii::$app->db->createCommand('ALTER DATABASE ' . $this->formModel->schemaName)->execute();
                return $this->redirect(['index']);
            } catch (\yii\db\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('alter');
    }

    public function actionDrop()
    {}

    public function actionDbSchema()
    {
        return $this->render('db_schema');
    }

    // ViewInterface
    public function mainAction(): array
    {
        return [
            'index' => [
                'route' => 'create',
                'label' => 'Create database',
            ],
        ];
    }

    public function viewActions(): array
    {
        return [
            'index' => [
                'privileges',
                'process_list',
                'variables',
                'status'
            ]
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

    // public function showViewSidebar(): bool
    // {
    //     return $this->action->id == 'index';
    // }

    // ListViewInterface
    public function listRouteId(): string
    {
        return '/admin/db-table';
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
