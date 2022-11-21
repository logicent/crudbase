<?php

namespace crudle\app\admin\models\auth;

use crudle\app\admin\enums\Db_Driver;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
        ];
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate())
            return false;

        // custom code here
        return true;
    }
}
