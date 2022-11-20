<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class TableForm extends Model
{
    public $tableName;
    public $engine; // '(engine)'
    public $collation = 'latin1_swedish_ci'; // '(collation)'
    public $autoIncrement;
    public $showDefaultValues;
    public $showComments;
    public $comment;
    public $columns;
    // partitionBy

    public function rules()
    {
        return [
            ['tableName', 'required', 'on' => 'index'],
            ['tableName', 'required'],
        ];
    }
}