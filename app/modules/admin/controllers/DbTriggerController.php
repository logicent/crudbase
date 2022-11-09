<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\controllers\action\Select;
use crudle\app\admin\models\DbTable;
use crudle\app\admin\models\search\DbTableSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;

class DbTriggerController extends DbObjectController
{
    public function actions()
    {
        return [
            // 'index' => Index::class,
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

    // ListViewInterface
    public function listRouteId(): string
    {
        return ''; // or explain
    }
}
