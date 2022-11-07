<?php

namespace crudle\app\admin\enums;

use Yii;

class Db_Driver
{
    const MySQL     = 'mysql';
    // const MariaDB   = 'mysql';
    // const Postgres  = 'pgsql';
    // const SQLite    = 'sqlite';
    // const SQLServer = 'sqlsrv';
    // const MSSQL     = 'mssql';
    // const ODBC      = 'odbc';
    // const Oracle    = 'oci';
    // const CUBRID    = 'cubrid';

    public static function enums()
    {
        return [
            self::MySQL     => Yii::t('app', 'MySQL'),
            // self::MariaDB   => Yii::t('app', 'MariaDB'),
            // self::Postgres  => Yii::t('app', 'PostgreSQL'),
            // self::SQLite    => Yii::t('app', 'SQLite'),
            // self::SQLServer => Yii::t('app', 'SQL Server'),
            // self::MSSQL     => Yii::t('app', 'MS SQL'),
            // self::ODBC      => Yii::t('app', 'ODBC'),
            // self::Oracle    => Yii::t('app', 'Oracle'),
            // self::CUBRID    => Yii::t('app', 'CUBRID'),
        ];
    }

    public static function dsnEnums()
    {
        return [
            self::MySQL     => "mysql:host={{hostname}};dbname={{database}}",
            // self::MariaDB   => "mysql:host={{hostname}};dbname={{database}}",
            // self::Postgres  => "pgsql:host={{hostname}};port={{port}};dbname={{database}}",
            // self::SQLite    => "sqlite:{{databaseFile}}", // file_path + file_name + file_ext
            // self::SQLServer => "sqlsrv:Server={{hostname}};Database={{database}}",
            // self::MSSQL     => "mssql:Server={{hostname}};dbname={{database}}",
            // self::ODBC      => 'odbc:Driver={{driverName}};Server={{hostname}};Database={{database}}',
            // self::Oracle    => "oci:dbname=//{{hostname}}:{{port}}/{{database}}",
            // self::CUBRID    => "cubrid:dbname={{database}};host={{hostname}};port={{port}}",
        ];
    }

    public static function requiredProperty()
    {
        return [
            // self::ODBC => ['driverName' => '{{driverName}}'],
            // self::SQLServer => [
            //     'attributes' => [
            //         \PDO::SQLSRV_ATTR_ENCODING => \PDO::SQLSRV_ENCODING_SYSTEM
            //     ]
            // ]
        ];
    }
}
