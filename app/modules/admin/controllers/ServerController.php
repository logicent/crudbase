<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\controllers\base\DbObjectController;
use crudle\app\main\enums\Type_View;

class ServerController extends DbObjectController
{
    public function actions()
    {
        return [
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    // ViewInterface
    public function mapActionToViewType()
    {
        switch ($this->action->id)
        {
            case 'create':
            case 'remove':
                return Type_View::Form;
            default: // index or other
                return $this->defaultActionViewType();
        }
    }

    public function mainAction(): array
    {
        return [
            'route' => 'create',
            'label' => 'Create connection',
        ];
    }

    public function viewActions(): array
    {
        return [
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
            'remove'
        ];
    }
}
