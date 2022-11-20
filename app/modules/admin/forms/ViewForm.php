<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class ViewForm extends Model
{
    public $viewName;
    public $cmd;

    public function rules()
    {
        return [
            ['viewName', 'required', 'on' => 'index'],
            ['viewName', 'required'],
        ];
    }
}