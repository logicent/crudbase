<?php

namespace crudle\app\admin\models;

use crudle\app\main\enums\Type_Model_Id;
use crudle\app\main\models\base\BaseActiveRecord;
use crudle\app\admin\enums\Permission_Group;
use crudle\app\admin\enums\Type_Permission;

/**
 * This is the model class for table "data_import".
 */
class DataImport extends BaseActiveRecord
{
    public function init()
    {
        parent::init();
        $this->listSettings->listNameAttribute = 'id';
    }

    public static function tableName()
    {
        return '{{%Data_Import}}';
    }

    // Workflow Interface
    public static function permissions()
    {
        return Type_Permission::enums(Permission_Group::Crud);
    }

    // ActiveRecord Interface
    public static function autoSuggestIdValue()
    {
        return true;
    }

    public static function autoSuggestIdType()
    {
        return Type_Model_Id::GeneratedUuid;
    }

    // public static function relations()
    // {
    //     return [
    //     ];
    // }
}
