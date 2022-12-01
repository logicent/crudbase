<?php

namespace crudle\app\enums;

// Core Modules
class Type_Module
{
    const Main      = 'main';
    const Admin     = 'admin';

    public static function enums()
    {
        return [
            self::Main      => self::Main,
            self::Admin     => self::Admin,
        ];
    }
}
