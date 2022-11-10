<?php

namespace crudle\app\admin\models;

use crudle\app\admin\enums\Type_Relation;
use crudle\app\main\models\base\BaseActiveRecord;
use Yii;

class Collation extends BaseActiveRecord
{
    // public function init()
    // {
    //     parent::init();
    //     $this->listSettings->listIdAttribute = 'COLLATION_NAME';
    //     $this->listSettings->listNameAttribute = 'COLLATION_NAME';
    // }

    public static function tableName()
    {
        return 'COLLATIONS';
    }

    public function rules()
    {
        return [
            [['COLLATION_NAME', 'CHARACTER_SET_NAME'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            // 'SCHEMA_NAME' => Yii::t('app', 'Database'),
        ];
    }

    public static function relations()
    {
        return [
            // 'dbTable' => [
            //     'class' => DbTable::class,
            //     'type' => Type_Relation::ChildModel
            // ],
            // 'dbView' => [
            //     'class' => DbView::class,
            //     'type' => Type_Relation::ChildModel
            // ]
        ];
    }

    // public function getDbTable()
    // {
    //     return $this->hasMany(DbTable::class, ['TABLE_SCHEMA' => 'SCHEMA_NAME']);
    // }

    // public function getDbView()
    // {
    //     return $this->hasMany(DbView::class, ['TABLE_SCHEMA' => 'SCHEMA_NAME']);
    // }
}