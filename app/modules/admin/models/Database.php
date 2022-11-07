<?php

namespace crudle\app\admin\models;

use crudle\app\admin\enums\Type_Relation;
use crudle\app\main\models\base\BaseActiveRecord;
use Yii;

class Database extends BaseActiveRecord
{
    public $table;
    public $size;

    public function init()
    {
        parent::init();
        $this->listSettings->listIdAttribute = 'SCHEMA_NAME';
        $this->listSettings->listNameAttribute = 'SCHEMA_NAME';
    }

    public static function tableName()
    {
        return 'SCHEMATA';
    }

    public function rules()
    {
        return [
            [['SCHEMA_NAME', 'DEFAULT_COLLATION_NAME'], 'string', 'max' => 140],
            [['tables', 'size'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'SCHEMA_NAME' => Yii::t('app', 'Database'),
            'DEFAULT_COLLATION_NAME' => Yii::t('app', 'Collation'),
            'tables' => Yii::t('app', 'Tables'),
            'size' => Yii::t('app', 'Size - Computed'),
        ];
    }

    public static function relations()
    {
        return [
            'dbTable' => [
                'class' => DbTable::class,
                'type' => Type_Relation::ChildModel
            ]
        ];
    }

    public function getDbTable()
    {
        return $this->hasMany(DbTable::class, ['TABLE_SCHEMA' => 'SCHEMA_NAME']);
    }
}