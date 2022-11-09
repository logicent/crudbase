<?php

namespace crudle\app\admin\forms;

use Yii;
use yii\base\Model;

class SqlCmdForm extends Model
{
    public $queryCmd;
    public $limitRows;
    public $stopOnError;
    public $showOnlyErrors;

    public function rules()
    {
        return [
            [['queryCmd'], 'string'],
            [['limitRows'], 'integer'],
            [['stopOnError', 'showOnlyErrors'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'queryCmd' => Yii::t('app', 'SQL Command'),
        ];
    }
}
