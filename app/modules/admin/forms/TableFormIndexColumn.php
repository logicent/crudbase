<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class TableFormIndexColumn extends Model
{
    public $columnName;
    public $length;

    public function rules()
    {
        return [
            ['columnName', 'required'],
        ];
    }
}