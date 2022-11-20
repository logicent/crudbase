<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class ProcedureFormParameter extends Model
{
    public $parameterName;
    public $type;
    public $length;
    public $options;

    public function rules()
    {
        return [
            ['parameterName', 'required', 'on' => 'index'],
            ['parameterName', 'required'],
        ];
    }
}