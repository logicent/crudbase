<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class ExportForm extends Model
{
    public $database;
    public $tables;
    public $data;
    public $format;
    public $output; // open, save, gzip
    // public $compressed;
    public $autoIncrement;
    public $routines;
    public $events;
    public $triggers;

    public function rules()
    {
        return [
        ];
    }

    public function attributeLabels()
    {
        return [
        ];
    }
}
