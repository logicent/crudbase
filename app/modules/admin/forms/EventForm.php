<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class EventForm extends Model
{
    public $eventName;
    public $startAt;
    public $endAt;
    public $every;
    public $everyPeriod;
    public $status;
    public $comment;
    public $onCompletionPreserve;
    public $cmd;

    public function rules()
    {
        return [
            ['eventName', 'required', 'on' => 'index'],
            ['eventName', 'required'],
        ];
    }
}