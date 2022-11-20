<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class TableFormColumn extends Model
{
    public $columnName;
    public $type;
    public $length;
    public $options;
    public $isNull;
    public $autoIncrement;
    public $defaultValue;
    public $comment;

    public function rules()
    {
        return [
            ['columnName', 'required', 'on' => 'index'],
            ['columnName', 'required'],
        ];
    }
}