<?php

namespace crudle\app\admin\controllers\action;

use crudle\app\admin\controllers\base\BaseAction;
use crudle\app\admin\forms\DbTableForm;
use crudle\app\admin\models\DbTable;
use Yii;
use yii\base\Action;
use yii\helpers\StringHelper;

class Index extends Action
{
    public function run()
    {
        $this->controller->redirectToLoginIfSessionHasExpired();

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
        $data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ];
        $view = '@appMain/views/list/index';
        if (Yii::$app->request->isAjax)
            return $this->controller->renderAjax($view, $data);
        else
            return $this->controller->render($view, $data);
    }
}
