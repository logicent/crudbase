<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\forms\ExportForm;
use crudle\app\main\controllers\base\BaseViewController;
use crudle\app\main\enums\Type_View;
use Yii;

class ExportController extends BaseViewController
{
    public function actions()
    {
        return [
        ];
    }

    /**
     * Renders the index view for the controller
     * @return string
     */
    public function actionIndex()
    {
        $model = new ExportForm();

        return $this->render('index', ['model' => $model]);
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
