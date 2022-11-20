<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class TransferForm extends Model
{
    public $schemaName;
    public $overwrite;

    public function rules()
    {
        return [
        ];
    }
}