<?php

namespace crudle\app\enums;

// Core Modules
class Type_Module
{
    const Main      = 'main';
    const Admin     = 'db_admin';

    public static function enums()
    {
        return [
            self::Main      => self::Main,
            self::Admin     => self::Admin,
        ];
    }
}
