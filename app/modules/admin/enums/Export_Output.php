<?php

namespace crudle\app\admin\enums;

use Yii;

class Export_Output
{
    const Open = 'Open';
    const Save = 'Save';
    const Gzip = 'Gzip';

    public static function enums()
    {
        return [
            self::Open => Yii::t('app', 'Open'),
            self::Save => Yii::t('app', 'Save'),
            self::Gzip => Yii::t('app', 'Gzip'),
        ];
    }
}