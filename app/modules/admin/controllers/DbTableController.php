<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\controllers\action\Select;
use crudle\app\admin\controllers\base\DbObjectController;
use crudle\app\admin\models\DbTable;
use crudle\app\admin\models\search\DbTableSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

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
        $tableSchema = Yii::$app->request->queryParams['SCHEMA_NAME'];
        $tableName = Yii::$app->request->queryParams['TABLE_NAME'];
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
            'columns' => $this->_getTableColumns($baseTable),
            'formModel' => $this->formModel,
            'searchModel' => new $searchModelClass(),
            'dataProvider' => $dataProvider,
        ];
        // $headers = Yii::$app->request->headers;
        // $isAjaxRequest = Yii::$app->request->isAjax || $headers->has('HX-Request');
        // if ($isAjaxRequest) // renderAjax
        //     return $this->render('/_list/index', $data);
        // else
            return $this->render('select', $data);
    }

    private function _getTableColumns($tableSchema)
    {
        $schema = Yii::$app->db->schema->getTableSchema($tableSchema);

        return array_keys($schema->columns);
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

        return $this->render('@appMain/views/crud/form');
    }

    // ViewInterface
    public function mainAction(): array
    {
        return [
            'label' => 'Alter table',
            'route' => 'alter'
        ];
    }

    public function viewActions(): array
    {
        return [
            'select',
            'show_structure',
            'new_item',
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
