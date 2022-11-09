<?php

namespace crudle\app\admin\models;

use crudle\app\admin\enums\Type_Relation;
use crudle\app\main\models\base\BaseActiveRecord;

class DbTableColumn extends BaseActiveRecord
{
    // TABLE_SCHEMA,
    // TABLE_NAME,
    // COLUMN_NAME,
    // ORDINAL_POSITION,
    // COLUMN_DEFAULT,
    // IS_NULLABLE,
    // DATA_TYPE,
    // CHARACTER_MAXIMUM_LENGTH,
    // CHARACTER_SET_NAME,
    // COLLATION_NAME,
    // COLUMN_TYPE,
    // COLUMN_KEY,
    // COLUMN_COMMENT,

    public function init()
    {
        parent::init();
        $this->listSettings->listIdAttribute = 'COLUMN_NAME';
        $this->listSettings->listNameAttribute = 'COLUMN_NAME';
    }

    public static function tableName()
    {
        return 'COLUMNS';
    }

    public static function relations()
    {
        return [
            'dbTable' => [
                'class' => DbTable::class,
                'type' => Type_Relation::ParentModel
            ]
        ];
    }

    public function getDbTable()
    {
        return $this->hasOne(DbTable::class, ['TABLE_NAME' => 'TABLE_NAME']);
    }
}