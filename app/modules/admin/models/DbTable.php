<?php

namespace crudle\app\admin\models;

use crudle\app\admin\enums\Type_Relation;
use crudle\app\main\models\base\BaseActiveRecord;

class DbTable extends BaseActiveRecord
{
    public function init()
    {
        parent::init();
        $this->listSettings->listIdAttribute = 'TABLE_NAME';
        $this->listSettings->listNameAttribute = 'TABLE_NAME';
    }

    public static function tableName()
    {
        return 'TABLES';
    }

    public static function relations()
    {
        return [
            'database' => [
                'class' => Database::class,
                'type' => Type_Relation::ParentModel
            ],
            'dbTableColumn' => [
                'class' => DbTableColumn::class,
                'type' => Type_Relation::ChildModel
            ],
        ];
    }

    public function getDatabase()
    {
        return $this->hasOne(Database::class, ['TABLE_SCHEMA' => 'SCHEMA_NAME']);
    }

    public function getDbTableColumn()
    {
        return $this->hasMany(DbTableColumn::class, ['TABLE_NAME' => 'TABLE_NAME']);
    }
}