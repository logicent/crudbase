<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\controllers\action\Select;
use crudle\app\admin\controllers\base\DbObjectController;
use crudle\app\admin\forms\TableRecord;
use crudle\app\admin\models\DbTable;
use crudle\app\admin\models\search\DbTableSearch;
use crudle\app\main\enums\Type_View;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class DbTableController extends DbObjectController
{
    public function actions()
    {
        return [
            // 'index' => Index::class,
            // 'select' => Select::class,
            // 'create' => Create::class,
            // 'alter' => Alter::class,
            // 'drop' => Drop::class,
            // 'truncate' => Truncate::class,
            // 'insert' => Insert::class,
            // 'update' => Update::class,
            // 'delete' => Delete::class,
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
        // if (empty(Yii::$app->request->get('DatabaseForm')['schemaName']))
        //     return $this->redirect(['db/index']);

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

    public function actionSelect()
    {
        $schemaName = Yii::$app->request->getQueryParam('SCHEMA_NAME');
        $tableName = Yii::$app->request->getQueryParam('TABLE_NAME');
        $baseTable = $schemaName .'.'. $tableName;
        $query = (new Query())->from($baseTable);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $formModelClass = $this->formModelClass();
        $this->formModel = new $formModelClass;
        $this->formModel->schemaName = $schemaName;
        $tableSchema = Yii::$app->db->schema->getTableSchema($baseTable);

        $searchModelClass = $this->searchModelClass();
        $data = [
            'tablePK' => $tableSchema->primaryKey,
            'columns' => array_keys($tableSchema->columns),
            'formModel' => $this->formModel,
            'searchModel' => new $searchModelClass(),
            'dataProvider' => $dataProvider,
        ];
        return $this->render('select', $data);
    }

    public function actionCreate()
    {
        $modelClass = $this->formModelClass(); 
        $this->formModel = new $modelClass;

        if ($this->formModel->load(Yii::$app->request->post()) && $this->formModel->validate()) {
            try {
                Yii::$app->db->createCommand('CREATE TABLE ' . $this->formModel->schemaName)->execute();
                return $this->redirect(['index']);
            } catch (\yii\db\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('@appAdmin/views/_form/index');
    }

    public function actionStructure()
    {
        // sidebar
        $modelClass = $this->formModelClass(); 
        $this->formModel = new $modelClass;
        // tableDef
        $schemaName = Yii::$app->request->get('SCHEMA_NAME');
        $tableName = Yii::$app->request->get('TABLE_NAME');
        $baseTable = $schemaName .'.'. $tableName;
        $tableSchema = Yii::$app->db->schema->getTableSchema($baseTable);

        $columns = ['COLUMN_NAME', 'COLUMN_TYPE', 'COLUMN_COMMENT']; // 'IS_NULLABLE',

        $dataProvider = new ArrayDataProvider([
            'allModels' => (new Query)->from('information_schema.COLUMNS')
                                ->select($columns)
                                ->where([
                                    'TABLE_SCHEMA' => $schemaName,
                                    'TABLE_NAME' => $tableName,
                                ])
                                ->all(),
            'sort' => [
                'attributes' => $columns,
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('structure', [
            'dataProvider' => $dataProvider,
            'columns' => $columns,
        ]);
    }

    public function actionNewEntry()
    {
        // sidebar
        $modelClass = $this->formModelClass(); 
        $this->formModel = new $modelClass;
        // tableDef
        if (Yii::$app->request->isGet) {
            $tableSchema = Yii::$app->request->get('SCHEMA_NAME');
            $tableName = Yii::$app->request->get('TABLE_NAME');
        }
        if (Yii::$app->request->isPost) {
            $tableSchema = Yii::$app->request->post('SCHEMA_NAME');
            $tableName = Yii::$app->request->post('TABLE_NAME');
        }
        $baseTable = $tableSchema .'.'. $tableName;
        $tableDef = Yii::$app->db->schema->getTableSchema($baseTable);

        $model = new TableRecord();
        if (Yii::$app->request->isGet) {
            $columnNames = ArrayHelper::getColumn($tableDef->columns, 'name');
            $model->defineAttributes($columnNames);
            return $this->render('data/new_entry', [
                'model' => $model,
                'tableDef' => $tableDef,
            ]);
        }

        if (Yii::$app->request->isPost) {
            $rowData = Yii::$app->request->post($model->formName());
            Yii::$app->db
                ->createCommand()
                ->insert($baseTable, $rowData)
                ->execute();
        }
        return $this->redirect(['select',
            'SCHEMA_NAME' => $tableSchema,
            'TABLE_NAME' => $tableName
        ]);
    }

    public function actionEdit()
    {
        // sidebar
        $modelClass = $this->formModelClass(); 
        $this->formModel = new $modelClass;
        // tableDef
        if (Yii::$app->request->isGet) {
            $tableSchema = Yii::$app->request->get('SCHEMA_NAME');
            $tableName = Yii::$app->request->get('TABLE_NAME');
            $tableId = Yii::$app->request->get('TABLE_ID');
        }
        if (Yii::$app->request->isPost) {
            $tableSchema = Yii::$app->request->post('SCHEMA_NAME');
            $tableName = Yii::$app->request->post('TABLE_NAME');
            $tableId = Yii::$app->request->post('TABLE_ID');
        }
        $baseTable = $tableSchema .'.'. $tableName;
        $tableDef = Yii::$app->db->schema->getTableSchema($baseTable);
        // model
        $model = new TableRecord();
        if (Yii::$app->request->isGet) {
            $columnNames = ArrayHelper::getColumn($tableDef->columns, 'name');
            $rowData = (new Query)
                    ->from($baseTable)
                    ->select($columnNames)
                    ->where([$tableDef->primaryKey[0] => $tableId])
                    ->one();
            $model->defineAttributes($columnNames);
            $model->setValuesByAttribute($rowData);

            return $this->render('data/edit', [
                'model' => $model,
                'tableDef' => $tableDef,
            ]);
        }

        if (Yii::$app->request->isPost) {
            $rowData = Yii::$app->request->post($model->formName());
            Yii::$app->db
                ->createCommand()
                ->upsert($baseTable, $rowData)
                ->execute();
        }
        return $this->redirect(['select',
            'SCHEMA_NAME' => $tableSchema,
            'TABLE_NAME' => $tableName
        ]);
    }

    // ViewInterface
    public function mapActionToViewType()
    {
        switch ($this->action->id)
        {
            case 'new-entry':
            case 'edit':
                return Type_View::Form;
            default: // index or other
                return $this->defaultActionViewType();
        }
    }

    public function mainAction(): array
    {
        return [
            'new-entry' => [
                'route' => 'new-entry',
                'label' => 'Save',
                'options' => [
                    'data' => [
                        'method' => 'post'
                    ]
                ]
            ],
            'edit' => [
                'route' => 'edit',
                'label' => 'Save',
                'options' => [
                    'data' => [
                        'method' => 'post'
                    ]
                ]
            ],
            'index' => [
                'route' => 'db/alter',
                'label' => 'Alter database',
            ],
            'select' => [
                'label' => 'Alter table',
                'route' => 'alter'
            ]
        ];
    }

    public function viewActions(): array
    {
        return [
            'index' => [
                'database_schema',
                'privileges',
            ],
            'select' => [
                'select',
                'show_structure',
                'new_entry',
            ]
        ];
    }

    public function menuActions(): array
    {
        return [
            'alter_index',
            'add_foreign_key',
            'add_trigger',
        ];
    }

    public function userActions(): array
    {
        return [
            'import',
        ];
    }

    // ListViewInterface
    public function listRouteId(): string
    {
        return 'select'; // or explain
    }

    public function batchActionsMenu(): array
    {
        return [
            'edit',
            'save',
            'clone',
            'delete',
            'export',
        ];
    }
}
