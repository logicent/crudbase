<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\controllers\action\Select;
use crudle\app\admin\models\DbTable;
use crudle\app\admin\models\search\DbTableSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;

class DbTableController extends DbObjectController
{
    public function actions()
    {
        return [
            // 'index' => Index::class,
            'select' => Select::class
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
        if (!Yii::$app->session->has('dbConfig'))
            return $this->redirect(['/app/login']);

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

        if (!empty($userFilters))
            $dataProvider = $searchModel->search($userFilters);
        else {
            $dataProvider = new ActiveDataProvider([
                'query' => $this->modelClass()::find()->where(['TABLE_SCHEMA' => ''])
            ]);
        }

        $formModelClass = $this->formModelClass();
        $this->formModel = new $formModelClass;
        $filterColumnName = 'SCHEMA_NAME';
        $this->formModel->schemaName = isset($userFilters[$filterColumnName]) ? $userFilters[$filterColumnName] : null;

        $data = [
            'formModel' => $this->formModel,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
        $view = '@appMain/views/list/index';
        $headers = Yii::$app->request->headers;
        if (Yii::$app->request->isAjax || $headers->has('HX-Request'))
            return $this->renderAjax($view, $data);
        else
            return $this->render($view, $data);
    }

    // ListViewInterface
    public function listRouteId(): string
    {
        return 'db-table/select'; // or explain
    }
}
