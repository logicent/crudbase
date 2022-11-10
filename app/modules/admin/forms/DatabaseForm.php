<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class DatabaseForm extends Model
{
    public $schemaName;
    public $collation = '(collation)';
    public $tables;

    public function rules()
    {
        return [
            ['schemaName', 'required', 'on' => 'index'],
            ['schemaName', 'required'],
        ];
    }
}