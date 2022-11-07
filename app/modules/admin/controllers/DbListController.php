<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\controllers\action\Index;
use crudle\app\admin\models\Database;
use crudle\app\admin\models\search\DatabaseSearch;
use crudle\app\helpers\App;
use crudle\app\main\controllers\base\BaseViewController;
use crudle\app\main\enums\Type_View;
use Yii;
use yii\data\SqlDataProvider;
use yii\helpers\ArrayHelper;

class DbListController extends BaseViewController
{
    public function modelClass(): string
    {
        return Database::class;
    }

    public function searchModelClass(): string
    {
        return DatabaseSearch::class;
    }

    public function actions()
    {
        return [
            'index' => Index::class
        ];
    }

    /**
     * Renders the create view for the controller
     * @return string
     */
    public function actionCreate()
    {
        return $this->render('create');
    }

    /**
     * Renders the alter view for the controller
     * @return string
     */
    public function actionAlter()
    {
        return $this->render('alter');
    }

    // ViewInterface
    public function defaultActionViewType()
    {
        return Type_View::List;
    }

    public function showViewHeader(): bool
    {
        return true;
    }

    public function showViewSidebar(): bool
    {
        return true;
    }
}
