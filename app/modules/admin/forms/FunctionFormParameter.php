<?php

namespace crudle\app\admin\forms;

class FunctionFormParameter extends ProcedureFormParameter
{
    public $type;
    public $length;
    public $options;

    public function rules()
    {
        return [
        ];
    }
}