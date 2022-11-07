<?php

namespace crudle\app\admin\enums;

// use Yii;

class Db_Object
{
    // Generic
    const Table = 'Table';
    const View = 'View';
    // Specific
    // MySQL
    // const Routines = 'Routines';
    // const Events = 'Events';
    // const Triggers = 'Triggers';
    // Postgres
    // const MaterialView = 'Material View';
    // SQL Server
    // const StoredProcedure = 'Stored Procedure';

    public static function enums()
    {
        return [
            self::View,
            self::Table,
        ];
    }
}