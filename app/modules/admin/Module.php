<?php

namespace crudle\app\admin;

use Yii;

/**
 * main module definition class
 */
class Module extends \yii\base\Module
{
    public $isActivated = true;

    public $moduleName = 'Admin';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'crudle\app\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}
