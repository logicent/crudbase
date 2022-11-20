<?php

namespace crudle\app\admin\controllers;

use crudle\app\main\controllers\base\BaseViewController;
use crudle\app\admin\models\Database;
use crudle\app\admin\models\search\DatabaseSearch;
use crudle\app\main\enums\Type_View;
use Yii;
use yii\helpers\StringHelper;

class ServerController extends DbObjectController
{
    public function actions()
    {
        return [
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
        $view = '@appMain/views/list/index';
        if (Yii::$app->request->isAjax)
            return $this->renderAjax($view, $data);
        else
            return $this->render('index', $data);
    }

    // ViewInterface
    public function mainAction()
    {
    }

    public function viewActions(): array
    {
        return [
            'create', // Create database
            'privileges',
            'process_list',
            'variables',
            'status'
        ];
    }

    public function menuActions(): array
    {
        return [];
    }

    public function userActions(): array
    {
        return [];
    }

    // ListViewInterface
    public function listRouteId(): string
    {
        return 'db';
    }

    public function batchActionsMenu(): array
    {
        return [
            'drop' // Drop database
        ];
    }
}
