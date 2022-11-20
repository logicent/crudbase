<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class TableDataForm extends Model
{
    public $wholeResult;
    public $selectedRows;
    public $exportFormat;
    public $exportOutput;
    public $importFile;
    public $importFormat;

    public function rules()
    {
        return [
        ];
    }
}