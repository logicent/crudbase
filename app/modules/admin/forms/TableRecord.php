<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class TableRecord extends Model
{
    public $schemaName;
    public $name;
    public $fullName;
    public $primaryKey;
    public $sequenceName;
    public $foreignKeys;
    public $columns;
    // public $indexes;

    public function rules()
    {
        return [
            [['schemaName', 'name', 'fullName', 'primaryKey', 'sequenceName', 'foreignKeys', 'columns'], 'safe']
        ];
    }
}