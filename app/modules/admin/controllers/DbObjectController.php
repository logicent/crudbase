<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\controllers\action\Index;
use crudle\app\admin\controllers\action\Select;
use crudle\app\admin\forms\DatabaseForm;
use crudle\app\main\controllers\base\BaseViewController;
use crudle\app\main\controllers\base\FormInterface;
use crudle\app\main\controllers\base\ListViewInterface;
use crudle\app\main\enums\Type_View;

abstract class DbObjectController extends BaseViewController implements ListViewInterface, FormInterface
{
    public $formModel;

    public function actions()
    {
        return [
            'index' => Index::class,
            'select' => Select::class
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

    // FormInterface
    public function formModelClass(): string
    {
        return DatabaseForm::class;
    }

    // public function formModel()
    // {
    // }

    // ListViewInterface
    public function listRouteId(): string
    {
        return '';
    }

    // ViewInterface
    public function getModel($id = null)
    {
        return $this->formModel;
    }

    public function setModel($model)
    {
        $this->formModel = $model;
    }

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
