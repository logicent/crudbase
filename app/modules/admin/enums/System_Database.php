<?php

namespace crudle\app\admin\enums;

class Permission_Group
{
    const InformationSchema = 'information_schema';
    const Mysql = 'mysql';
    const PerformanceSchema = 'performance_schema';
    const Sys = 'sys';

    public static function enums()
    {
        return [
            self::InformationSchema  => self::InformationSchema,
            self::Mysql => self::Mysql,
            self::PerformanceSchema => self::PerformanceSchema,
            self::Sys => self::Sys,
        ];
    }
}