<?php

namespace crudle\app\admin\forms;

use crudle\app\main\models\UploadForm;
use Yii;
use yii\base\Model;

class ImportForm extends Model
{
    // public $importFromGoogleSheets; // Must be a publicly accessible Google Sheets URL
    public $fileType;
    // public $doNotSendEmails = true;
    public $uploadForm;
    public $import_file;
    public $stopOnError;
    public $showOnlyErrors;

    // Import File Errors and Warnings
    // Preview in non-editable grid, allow alternate column mapping and show warnings
    // Import Log
    // public $showFailedLogs {RowNumber, Status, Message}

    // public function init()
    // {
    //     $this->uploadForm = new UploadForm();
    //     $this->fileAttribute = 'import_file';
    // }

    public function rules()
    {
        return [
            [['import_file'], 'file'],
            // [['import_file'], 'file', 'extensions' => ['gz', 'sql']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'import_file' => Yii::t('app', 'Data file'),
        ];
    }
}
