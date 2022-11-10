<?php

namespace crudle\app\admin\controllers;

use crudle\app\main\controllers\base\BaseViewController;
use crudle\app\main\controllers\base\FormInterface;
use crudle\app\main\enums\Type_View;
use Yii;

abstract class DbFormController extends BaseViewController implements FormInterface
{
    public $formModel;

    public function beforeAction($action)
    {
        // If database credentials not found
        if (!Yii::$app->session->has('dbConfig'))
            return $this->redirect(['/app/login']);

        if (!parent::beforeAction($action)) {
            return false; // do not run the action
        }

        return true; // run the action
    }

    // FormInterface
    public function formModelClass(): string
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
        return Type_View::Form;
    }
}
