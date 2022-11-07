<?php

namespace crudle\app\admin\enums;


class Db_Type
{
    const Integer   = 'int';
    const Varchar   = 'varchar';

    public static function enums()
    {
        return [
            self::Integer,
            self::Varchar,
        ];
    }
}