<?php

namespace crudle\app\admin\models;

use crudle\app\admin\enums\Type_Relation;
use crudle\app\main\models\base\BaseActiveRecord;

class DbTableConstraint extends BaseActiveRecord
{
    public static function tableName()
    {
        return 'TABLE_CONSTRAINTS';
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