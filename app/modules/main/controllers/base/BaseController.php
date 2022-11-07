<?php

namespace crudle\app\main\controllers\base;

use yii\web\Controller;

abstract class BaseController extends Controller
{
    protected $model;

    public function refresh($anchor = '')
    {
        // stop executing this action and refresh the current page
        return $this->refresh();
    }
}
