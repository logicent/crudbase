<?php

namespace crudle\app\admin\controllers;

use crudle\app\main\controllers\base\BaseViewController;
use crudle\app\main\controllers\base\FormInterface;
use crudle\app\main\enums\Type_View;
use Yii;

abstract class DbFormController extends BaseViewController implements FormInterface
{
    public $formModel;

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
