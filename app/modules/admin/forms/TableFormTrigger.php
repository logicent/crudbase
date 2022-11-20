<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class TableFormTrigger extends Model
{
    public $triggerName;
    public $time;
    public $event;
    public $type;
    public $cmd;

    public function rules()
    {
        return [
            ['triggerName', 'required', 'on' => 'index'],
            ['triggerName', 'required'],
        ];
    }
}