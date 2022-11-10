<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\forms\ExportForm;

class ExportController extends DbFormController
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

    // FormInterface
    public function formModelClass(): string
    {
        return ExportForm::class;
    }
}
