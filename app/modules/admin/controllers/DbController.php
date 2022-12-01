<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\controllers\base\DbObjectController;
use crudle\app\admin\forms\DatabaseForm;
use crudle\app\admin\forms\PrivilegeForm;
use crudle\app\admin\models\Database;
use crudle\app\admin\models\search\DatabaseSearch;
use crudle\app\main\enums\Type_View;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
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

        // $model = new DatabaseForm();

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
        $tableSchema = 'mysql'; // to be determined based on driver/connection
        $tableName = 'user'; // to be determined based on driver/connection
        $baseTable = $tableSchema .'.'. $tableName;
        $query = (new Query())->from($baseTable);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $formModelClass = $this->formModelClass();
        $this->formModel = new $formModelClass;
        $this->formModel->schemaName = $tableSchema;

        $searchModelClass = $this->searchModelClass();
        $data = [
            'columns' => ['User', 'Host'],
            'formModel' => $this->formModel,
            'searchModel' => new $searchModelClass(),
            'dataProvider' => $dataProvider,
        ];

        if ($this->formModel->load(Yii::$app->request->post()) && $this->formModel->validate()) {
            try {
                // Yii::$app->db->createCommand('CREATE USER ' . $this->formModel->schemaName)->execute();
                return $this->redirect(['index']);
            } catch (\yii\db\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('privileges', $data);
    }

    public function actionCreateUser()
    {
        $formModelClass = $this->formModelClass();
        $this->formModel = new $formModelClass;

        $model = new PrivilegeForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                // Yii::$app->db->createCommand('CREATE USER ' . $model->schemaName)->execute();
                return $this->redirect(['index']);
            } catch (\yii\db\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create_user', ['model' => $model]);
    }

    public function actionProcessList()
    {
        $tableSchema = 'information_schema'; // to be determined based on driver/connection
        $tableName = 'processlist'; // to be determined based on driver/connection
        $baseTable = $tableSchema .'.'. $tableName;
        $query = (new Query())->from($baseTable);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $formModelClass = $this->formModelClass();
        $this->formModel = new $formModelClass;
        $this->formModel->schemaName = $tableSchema;

        $searchModelClass = $this->searchModelClass();
        $data = [
            'columns' => ['ID', 'USER', 'HOST', 'DB', 'COMMAND', 'TIME', 'STATE', 'INFO'],
            'formModel' => $this->formModel,
            'searchModel' => new $searchModelClass(),
            'dataProvider' => $dataProvider,
        ];

        return $this->render('process_list', $data);
    }

    public function actionVariables()
    {
        $tableSchema = 'performance_schema'; // to be determined based on driver/connection
        $tableName = 'session_variables'; // to be determined based on driver/connection
        $baseTable = $tableSchema .'.'. $tableName;
        $query = (new Query())->from($baseTable);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0
            ]
        ]);

        $formModelClass = $this->formModelClass();
        $this->formModel = new $formModelClass;
        $this->formModel->schemaName = $tableSchema;

        $searchModelClass = $this->searchModelClass();
        $data = [
            'columns' => ['VARIABLE_NAME', 'VARIABLE_VALUE'],
            'formModel' => $this->formModel,
            'searchModel' => new $searchModelClass(),
            'dataProvider' => $dataProvider,
        ];

        return $this->render('variables', $data);
    }

    public function actionStatus()
    {
        $tableSchema = 'performance_schema'; // to be determined based on driver/connection
        $tableName = 'session_status'; // to be determined based on driver/connection
        $baseTable = $tableSchema .'.'. $tableName;
        $query = (new Query())->from($baseTable);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0
            ]
        ]);

        $formModelClass = $this->formModelClass();
        $this->formModel = new $formModelClass;
        $this->formModel->schemaName = $tableSchema;

        $searchModelClass = $this->searchModelClass();
        $data = [
            'columns' => ['VARIABLE_NAME', 'VARIABLE_VALUE'],
            'formModel' => $this->formModel,
            'searchModel' => new $searchModelClass(),
            'dataProvider' => $dataProvider,
        ];

        return $this->render('status', $data);
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

        $model = new DatabaseForm();

        if (Yii::$app->request->isGet)
        {
            $schemaName = Yii::$app->request->getQueryParam('SCHEMA_NAME');
            // $sqlCmd = <<<SQL
            $sqlCmd = "
                SELECT SCHEMA_NAME, DEFAULT_COLLATION_NAME FROM SCHEMATA WHERE SCHEMA_NAME = '$schemaName'
            ";
            // SQL;
            $dbSchema = Yii::$app->db->createCommand($sqlCmd)->queryOne();
            $model->schemaName = $dbSchema['SCHEMA_NAME'];
            $model->collation = $dbSchema['DEFAULT_COLLATION_NAME'];
        }

        if (Yii::$app->request->isPost)
        {
            $formData = Yii::$app->request->post($model->formName());
            // To-Do: dynamic validate here
            try {
                // CREATE..RENAME..DROP
                $sqlCmd = "ALTER DATABASE '" . $formData['schemaName'] . "'";
                Yii::$app->db->createCommand($sqlCmd)->execute();
                return $this->redirect(['index']);
            } catch (\yii\db\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            $model->schemaName = $formData['schemaName'];
            $model->collation = $formData['collation'];
        }

        return $this->render('alter', ['model' => $model]);
    }

    public function actionDrop()
    {}

    public function actionSchema()
    {
        $modelClass = $this->formModelClass(); 
        $this->formModel = new $modelClass;

        return $this->render('db_schema');
    }

    // ViewInterface
    public function mapActionToViewType()
    {
        switch ($this->action->id)
        {
            case 'create':
            case 'alter':
                return Type_View::Form;
            default: // index
                return $this->defaultActionViewType();
        }
    }

    public function mainAction(): array
    {
        return [
            'index' => [
                'route' => 'create',
                'label' => 'Create database',
            ],
            'privileges' => [
                'route' => 'create-user',
                'label' => 'Create user',
                'options' => [
                    'data' => [
                        'hx-get' => \yii\helpers\Url::to(['create-user']),
                        'hx-target' => 'body > div.main',
                        'hx-push-url' => 'true',
                        'hx-swap' => 'outerHTML'
                    ]
                ]
            ],
            'alter' => [
                'route' => 'alter',
                'label' => 'Save',
                'options' => [
                    'data' => [
                        'method' => 'post'
                    ]
                ]
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
