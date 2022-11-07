<?php

namespace crudle\app\main\models;

use crudle\app\main\enums\Type_Mixed_Value;
use crudle\app\main\enums\Type_Relation;
use crudle\app\main\models\UploadForm;
use crudle\app\main\models\base\BaseSettingsForm;
use Yii;

class LayoutSettingsForm extends BaseSettingsForm
{
    public $pinMainSidebar      = false;
    public $showHelpInfo        = false;
    public $allowUserPreference = true;
    // public $flashMessagePosition; // Top/Bottom:Left/Center/Right

    // public $hideBreadcrumbs = false;
    // public $hideMainSidebar = false;
    // public $mainSidebarView = MainSidebar::Collapsed/MainSidebar::Expanded // (stretched);
    // public $mainSidebarShowStatLabel = false;
    // public $mainSidebarShowIconsOnly; // (if collapsed)

    public function rules()
    {
        return [
            [[
                'pinMainSidebar',
                'showHelpInfo',
                'allowUserPreference',
            ], 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            'showHelpInfo'      =>  Yii::t('app', 'Show help info'),
            'pinMainSidebar'    =>  Yii::t('app', 'Pin main sidebar'),
            'allowUserPreference'   =>  Yii::t('app', 'Allow user preferences'),
            // 'flashMessagePosition'    =>  Yii::t('app', 'Flash message position'),
        ];
    }

    public static function relations(): array
    {
        return [
        ];
    }

    public static function hasMixedValueFields(): bool
    {
        return true;
    }

    public static function mixedValueFields(): array
    {
        return [
            // Type_Mixed_Value::JsonFormatted => [
            // ]
        ];
    }
}
