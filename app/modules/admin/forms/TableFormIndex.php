<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class TableFormIndex extends Model
{
    public $indexType;
    public $columns;
    public $name;

    public function rules()
    {
        return [
            ['indexType', 'required'],
        ];
    }
}