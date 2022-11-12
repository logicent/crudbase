<?php

namespace crudle\app\main\controllers\base;

use crudle\app\main\enums\Type_Form_View;
use crudle\app\main\enums\Type_View;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Url;

abstract class BaseViewController extends BaseController implements LayoutInterface, ViewInterface
{
    protected $name; // view name
    protected $validationErrors = [];
    protected $supportedViewTypes = [];

    public $layout = '@appMain/views/_layouts/main';

    public function init()
    {
        parent::init();
        Yii::$app->language = Yii::$app->request->cookies->getValue('language', 'en');

        $this->viewPath = dirname($this->viewPath) .'/'. Inflector::underscore(
            Inflector::id2camel(StringHelper::basename($this->id))
        );

        $this->name = Inflector::camel2words(
            Inflector::id2camel(StringHelper::basename($this->id), '/')
        );
    }

    public function beforeAction($action)
    {
        // If database credentials not found
        if (!Yii::$app->session->has('dbConfig') &&
            $this->action->id !== '' &&
            $this->action->id !== 'login'
        )
        {
            $headers = Yii::$app->request->headers;
            if ($headers->has('HX-Request'))
                $this->redirect(['/app/login'], 302); // !! Experimental : Testing behavior
            else
                $this->redirect(['/app/login']);
            return false; // do not run the action
        }

        if (!parent::beforeAction($action)) {
            return false; // do not run the action
        }

        Yii::$app->set('db', Yii::$app->session->get('dbConfig'));
        Url::remember(Yii::$app->request->getUrl(), 'go back');

        return true; // run the action
    }

    // public function afterAction($action, $result)
    // {
    //     $result = parent::afterAction($action, $result);
    //     // your custom code here
    //     // Yii::$app->response->statusCode = 204;
    //     return $result;
    // }

    // public function actions()
    // {
    //     return ArrayHelper::merge(parent::actions(), [
    //     ]);
    // }

    // LayoutInterface
    public function allowThemeChange(): bool
    {
        return false;
    }

    public function currentTheme(): string
    {
        return 'default';
    }

    public function supportedThemes(): array
    {
        return [];
    }

    public function allowThemeCustomization(): bool
    {
        return false;
    }

    public function mapActionViewType()
    {
        switch ($this->action->id)
        {
            case 'view-list':
                return Type_View::List;
            case 'view-tree':
                return Type_View::Tree;
            case 'view-workspace':
                return Type_View::Workspace;
            case 'create':
            case 'update':
                return Type_View::Form;
            default: // index or other
                return $this->defaultActionViewType();
        }
    }

    public function showViewTypeSwitcher(): bool
    {
        return false;
    }

    public function showViewFilterButton(): bool
    {
        return true;
    }

    public function getViewFilterButtonState()
    {
    }

    public function setViewFilterButtonState()
    {
    }

    public function pageNavbar(): string
    {
        return $this->layout . '/_navbar';
    }

    public function showViewHeader(): bool
    {
        return true;
    }

    public function showMainSidebar(): bool
    {
        return true;
    }

    public function showViewSidebar(): bool
    {
        return true;

        switch ($this->action->id)
        {
            case 'index':
                if ($this->formViewType() == Type_Form_View::Single ||
                    $this->defaultActionViewType() == Type_View::List)
                    return true;
            case 'create':
            case 'update':
                return true;
            default:
        }
    }

    public function sidebarMenus(): array
    {
        return [];
    }

    public function sidebarColWidth(): string
    {
        return 'three';
    }

    public function mainColumnWidth(): string
    {
        return 'twelve';
    }

    public function fullColumnWidth(): string
    {
        return 'fourteen';
    }

    public function showQuickReportMenu(): bool
    {
        return false;
    }

    public function quickReportMenu(): array
    {
        return [];
    }

    public function showActiveUsers(): bool
    {
        return false;
    }

    // ViewInterface
    public function viewName(): string
    {
        return $this->name;
    }

    public function showTabbedViews(): bool
    {
        return false;
    }

    public function searchModelClass(): string
    {
        return '';
    }

    public function searchModel()
    {}

    public function modelClass(): string
    {
        return '';
    }

    public function getModel($id = null)
    {
        return $this->model ??= $this->findModel($id);
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function redirectTo(string $action = null)
    {}

    public function validationErrors(): array
    {
        return [];
    }
}
