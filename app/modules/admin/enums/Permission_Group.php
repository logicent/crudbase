<?php

namespace crudle\app\admin\enums;

class Permission_Group
{
    const All  = 'All';
    const Crud = 'Crud'; // Basic
    const Data = 'Data'; // Admin

    public static function enums()
    {
        return [
            self::All  => self::All,
            self::Crud => self::Crud,
            self::Data => self::Data,
        ];
    }
}