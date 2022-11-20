<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class TableFormForeignKey extends Model
{
    public $schemaName;
    public $targetName;
    public $columns;
    public $onDelete; // RESTRICT
    public $onUpdate; // RESTRICT

    public function rules()
    {
        return [
            [['schemaName', 'targetName'], 'required'],
        ];
    }
}