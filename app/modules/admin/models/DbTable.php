<?php

namespace crudle\app\admin\models;

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

    public function rules()
    {
        return [
            ['TABLE_SCHEMA', 'required', 'on' => 'index'],
            [['TABLE_SCHEMA', 'TABLE_NAME', 'TABLE_COLLATION'], 'string', 'max' => 140],
            ['TABLE_COMMENT', 'safe'],
            // [['ENGINE', 'range', 'in' => Db_Engine_Type::enums()],
            [['TABLE_ROWS', 'AUTO_INCREMENT'], 'integer'],
        ];
    }
}