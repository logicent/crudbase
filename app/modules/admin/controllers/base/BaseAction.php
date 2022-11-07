<?php

namespace crudle\app\admin\controllers\base;

use Yii;
use yii\base\Action;
use yii\helpers\StringHelper;

class BaseAction extends Action
{
    public function init()
    {
        parent::init();
        // fetch the list of all databases
        $hasDbConfig = Yii::$app->session->has('dbConfig');
        if (!$hasDbConfig) {
            return $this->controller->redirect(['/app/login']);
        }
    }
}
