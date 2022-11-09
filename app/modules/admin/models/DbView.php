<?php

namespace crudle\app\admin\models;

use crudle\app\admin\enums\Type_Relation;
use crudle\app\main\models\base\BaseActiveRecord;

class DbView extends BaseActiveRecord
{
    public function init()
    {
        parent::init();
        $this->listSettings->listIdAttribute = 'TABLE_NAME';
        $this->listSettings->listNameAttribute = 'TABLE_NAME';
    }

    public static function tableName()
    {
        return 'VIEWS';
    }

    // TABLE_SCHEMA
    // TABLE_NAME
    // VIEW_DEFINITION
    // IS_UPDATABLE
    // CHARACTER_SET_CLIENT
    // COLLATION_CONNECTION

    public static function relations()
    {
        return [
            'database' => [
                'class' => Database::class,
                'type' => Type_Relation::ParentModel
            ]
        ];
    }

    public function getDatabase()
    {
        return $this->hasOne(Database::class, ['TABLE_SCHEMA' => 'SCHEMA_NAME']);
    }
}