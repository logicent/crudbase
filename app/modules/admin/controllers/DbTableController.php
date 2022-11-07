<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\controllers\action\Index;
use crudle\app\admin\models\DbTable;
use crudle\app\admin\models\search\DbTableSearch;
use crudle\app\main\controllers\base\BaseViewController;
use crudle\app\main\enums\Type_View;
use Yii;
use yii\data\SqlDataProvider;

class DbTableController extends BaseViewController
{
    public function modelClass(): string
    {
        return DbTable::class;
    }

    public function searchModelClass(): string
    {
        return DbTableSearch::class;
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
        return Type_View::Workspace;
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
