<?php

use crudle\app\helpers\App;

return [
    'user.passwordResetTokenExpire' => 3600,

    'appName' => App::env('CRUDLE_APP_NAME'),
    'appShortName' => 'Crudbase',
    'appDescription' => 'A relational database administration tool',
    'appUrl' => 'https://github.com/logicent/crudbase',
    'appCopyright' => '&copy; 2020 Appsoft',

    'appVersion' => '1.0.0-alpha',
    'mobileAppVersion' => 'N/A',
    'appDeveloper' => '@mwaigichuhi',

    'helpUrl' => 'https://github.com/logicent/crudbase/wiki',

    // 'flashMessagePositionY' => 'bottom',
    // 'flashMessagePositionX' => 'right',
    // 'flashMessageDuration' => 6000
];
