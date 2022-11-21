<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class RouteParamForm extends Model
{
    public $user;
    public $db;
    public $tbl;
    public $select;
    public $create;
    public $update; // alter
    public $edit; // insert/update

    public function rules()
    {
        return [
            ['user', 'required'],
            [['db', 'tbl', 'select', 'create', 'update', 'edit'], 'string'],
        ];
    }
}