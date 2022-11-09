<?php

namespace crudle\app\admin\models;

use Yii;
use yii\base\Model;

class DbBackupSettingsForm extends Model
{
    public $includeTables =[];
    public $excludeTables = [];
    public $hiddenColumns = [];
    public $file;
    public $useCompression = true;
    public $comments;
    public $keepBackupsFor;

    public function rules()
    {
        return [
            [['keepBackupsFor'], 'required'],
            [['useCompression'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'useCompression' => Yii::t('app', 'Use compression'),
            'keepBackupsFor' => Yii::t('app', 'Keep backups for'),
        ];
    }
}
