<?php

namespace crudle\app\admin\controllers;

use crudle\app\admin\forms\ImportForm;

class ImportController extends DbFormController
{
    public function actions()
    {
        return [
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new ImportForm();

        return $this->render('index', ['model' => $model]);
    }

    // FormInterface
    public function formModelClass(): string
    {
        return ImportForm::class;
    }
}
