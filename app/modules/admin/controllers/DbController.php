<?php

namespace crudle\app\admin\controllers;

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
        $view = '@appMain/views/list/index';
        if (Yii::$app->request->isAjax)
            return $this->renderAjax($view, $data);
        else
            return $this->render('index', $data);
    }

    public function actionServer()
    {}

    public function actionCollation()
    {}

    public function actionEngine()
    {}

    public function actionCharacterSet()
    {}

    public function actionCreate()
    {}

    // Rename ?
    public function actionAlter()
    {}

    public function actionDrop()
    {}

    // ListViewInterface
    public function listRouteId(): string
    {
        return 'db-table';
    }
}
