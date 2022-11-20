<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class TableFormForeignKeyColumn extends Model
{
    public $sourceName;
    public $targetName;

    public function rules()
    {
        return [
            [['sourceName', 'targetName'], 'required'],
        ];
    }
}