<?php

namespace crudle\app\admin\forms;

use crudle\app\main\models\UploadForm;
use Yii;
use yii\base\Model;

class ImportForm extends Model
{
    public $fileType = 'application/gzip, application/zip, text/plain, text/csv, application/vnd.ms-excel'; // .zip, .csv, .xls?
    public $uploadForm;
    public $fileAttribute = 'import_file';
    public $import_file;
    public $stopOnError = true;
    public $showOnlyErrors = true;

    // Import File Errors and Warnings
    // Preview in non-editable grid, allow alternate column mapping and show warnings
    // Import Log
    // public $showFailedLogs {RowNumber, Status, Message}

    public function init()
    {
        $this->uploadForm = new UploadForm();
        // $this->fileAttribute = 'import_file';
    }

    public function rules()
    {
        return [
            [['import_file'], 'file', 'skipOnEmpty' => false, 'mimeTypes' => $this->fileType],
            [['stopOnError', 'showOnlyErrors'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            // 'import_file' => Yii::t('app', 'Import File'),
        ];
    }
}
