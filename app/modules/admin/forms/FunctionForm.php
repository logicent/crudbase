<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class FunctionForm extends Model
{
    public $functionName;
    public $parameters;
    public $cmd;

    public function rules()
    {
        return [
            ['functionName', 'required', 'on' => 'index'],
            ['functionName', 'required'],
        ];
    }
}