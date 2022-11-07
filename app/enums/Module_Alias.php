<?php

namespace crudle\app\enums;

class Module_Alias
{
    const Main      = '@appMain';
    const Setup     = '@appSetup';
    const Ext       = '@extModules';

    const AppNsPathname  = 'app';
    const ExtNsPathname  = 'ext';

    public static function enums()
    {
        return [
            self::Main      => self::Main,
            self::Setup     => self::Setup,
            self::Ext    => self::Ext,
        ];
    }

    public static function nsPathname()
    {
        return [
            self::Main => self::AppNsPathname,
            self::Setup => self::AppNsPathname,
            self::Ext => self::ExtNsPathname,
        ];
    }
}
