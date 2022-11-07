<?php

namespace crudle\app\admin\enums;

use Yii;

class Export_Output
{
    const Text = 'Text';
    const Save = 'Save';
    const Gzip = 'Gzip';

    public static function enums()
    {
        return [
            self::Text => Yii::t('app', 'Text'),
            self::Save => Yii::t('app', 'Save'),
            self::Gzip => Yii::t('app', 'Gzip'),
        ];
    }
}