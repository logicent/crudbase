<?php

namespace crudle\app\admin\forms;

use yii\base\Model;

class PrivilegeForm extends Model
{
    public $server = 'localhost';
    public $username;
    public $password;
    public $hashed;
    public $privileges;

    public function rules()
    {
        return [
            ['server', 'required'],
        ];
    }
}