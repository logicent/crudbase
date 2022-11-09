<?php

namespace crudle\app\admin;

use Yii;
use yii\base\BootstrapInterface;

/**
 * main module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
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

    /**
     * {@inheritdoc}
     */
    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $app->getUrlManager()->addRules([
                // ['class' => 'yii\web\UrlRule', 'pattern' => 'app', 'route' => $this->id . '/admin/index'], // defaultRoute requires this rule
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/login', 'route' => $this->id . '/admin/login'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/logout', 'route' => $this->id . '/admin/logout'],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-server', 'route' => $this->id . '/db-server/index'],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db', 'route' => $this->id . '/db/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db/create', 'route' => $this->id . '/db/create'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db/alter', 'route' => $this->id . '/db/alter'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db/drop', 'route' => $this->id . '/db/drop'],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-table', 'route' => $this->id . '/db-table/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-table/create', 'route' => $this->id . '/db-table/create'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-table/alter', 'route' => $this->id . '/db-table/alter'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-table/drop', 'route' => $this->id . '/db-table/drop'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-table/select', 'route' => $this->id . '/db-table/select'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-table/insert', 'route' => $this->id . '/db-table/insert'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-table/update', 'route' => $this->id . '/db-table/update'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-table/delete', 'route' => $this->id . '/db-table/delete'],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-view', 'route' => $this->id . '/db-view/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-view/create', 'route' => $this->id . '/db-view/create'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-view/alter', 'route' => $this->id . '/db-view/alter'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-view/drop', 'route' => $this->id . '/db-view/drop'],

                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/db-cmd', 'route' => $this->id . '/db-cmd/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/import', 'route' => $this->id . '/import/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => 'app/export', 'route' => $this->id . '/export/index'],
            ], false);
        }
        // elseif ($app instanceof \yii\console\Application) {
        //     $app->controllerMap[$this->id] = [
        //         'class' => "crudle\{$this->id}\console\DbAdminController",
        //         'module' => $this,
        //     ];
        // }
    }
}
