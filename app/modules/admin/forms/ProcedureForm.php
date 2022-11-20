<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class ProcedureForm extends Model
{
    public $procedureName;
    public $parameters;
    public $cmd;

    public function rules()
    {
        return [
            ['procedureName', 'required', 'on' => 'index'],
            ['procedureName', 'required'],
        ];
    }
}