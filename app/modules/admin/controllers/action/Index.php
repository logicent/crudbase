<?php

namespace crudle\app\admin\controllers\action;

use crudle\app\admin\controllers\base\BaseAction;
use Yii;
use yii\base\Action;
use yii\helpers\StringHelper;

class Index extends Action
{
    public function run()
    {
        // fetch the list of all databases
        $hasDbConfig = Yii::$app->session->has('dbConfig');
        if (!$hasDbConfig) {
            return $this->controller->redirect(['/app/login']);
        }

        $searchModelClass = $this->controller->searchModelClass();
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

        $dataProvider = $searchModel->search($userFilters);

        if (Yii::$app->request->isAjax)
            return $this->controller->renderAjax('@appMain/views/list/index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        else
            return $this->controller->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }
}
