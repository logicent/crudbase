<?php

namespace crudle\app\admin\enums;

use Yii;

class Export_Format
{
    const SQL = 'SQL';
    const CSV = 'CSV';
    const TSV = 'TSV';

    public static function enums()
    {
        return [
            self::SQL => Yii::t('app', 'SQL'),
            self::CSV => Yii::t('app', 'CSV'),
            self::TSV => Yii::t('app', 'TSV'),
        ];
    }
}