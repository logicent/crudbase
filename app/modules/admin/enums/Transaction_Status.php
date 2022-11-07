<?php

namespace crudle\app\admin\models;

class DbTransaction_Status
{
    const BeginTrans= 'BeginTrans';
    const Rollback  = 'Rollback';
    const Commit    = 'Commit';

    public static function enums()
    {
        return [
            self::BeginTrans =>  self::BeginTrans,
            self::Rollback =>  self::Rollback,
            self::Commit =>  self::Commit,
        ];
    }
}