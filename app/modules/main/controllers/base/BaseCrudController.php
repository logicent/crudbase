<?php

namespace crudle\app\main\controllers\base;

use crudle\app\helpers\Uploader;
use crudle\app\main\controllers\base\BaseViewController;
use crudle\app\admin\controllers\action\AddRow;
use crudle\app\admin\controllers\action\Alert;
use crudle\app\admin\controllers\action\AutoIncrement;
use crudle\app\admin\controllers\action\Create;
use crudle\app\admin\controllers\action\DeleteMany;
use crudle\app\admin\controllers\action\DeleteRow;
use crudle\app\admin\controllers\action\UpdateRow;
use crudle\app\admin\controllers\action\FindItem;
use crudle\app\admin\controllers\action\Index;
use crudle\app\admin\controllers\action\SaveComment;
use crudle\app\admin\controllers\action\ShowCommentModal;
use crudle\app\admin\controllers\action\Update;
use crudle\app\admin\controllers\action\Batch;
use crudle\app\admin\controllers\action\Download;
use crudle\app\admin\controllers\action\ExportText;
use crudle\app\admin\controllers\action\RestoreDefaults;
use crudle\app\admin\controllers\action\SwitchViewType;
use crudle\app\main\enums\Type_Form_View;
use crudle\app\main\enums\Type_View;
use crudle\app\setup\enums\Type_Permission;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;

abstract class BaseCrudController extends BaseViewController implements CrudInterface
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'list'],
                        'allow' => true,
                        'roles' => [ Type_Permission::List .' '. $this->viewName() ],
                    ],
                    [
                        'actions' => ['update'], // edit
                        'allow' => true,
                        'roles' => [ Type_Permission::Update .' '. $this->viewName() ],
                    ],
                    [
                        'actions' => ['create'], // addNew
                        'allow' => true,
                        'roles' => [ Type_Permission::Create .' '. $this->viewName() ],
                    ],
                    [
                        'actions' => ['delete', 'delete-many'],
                        'allow' => true,
                        'roles' => [ Type_Permission::Delete .' '. $this->viewName() ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'delete-many' => ['POST'],
                ],
            ],
        ];
    }

    public function showQuickEntry(): bool
    {
        return false;
    }

    public function formViewType()
    {
        return Type_Form_View::Multiple;
    }

    public function showLinkedData(): bool
    {
        return true;
    }

    public function showComments(): bool
    {
        return true;
    }

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'index'                 => Index::class,
            'batch'                 => Batch::class,
            'switch-view-type'      => SwitchViewType::class,
            'download'              => Download::class,
            'export-text'           => ExportText::class,
            'restore-defaults'      => RestoreDefaults::class,
            'create'        => Create::class,
            'update'        => Update::class,
            'cancel'        => Cancel::class,
            'alert'         => Alert::class,
            'delete'        => Delete::class,
            'delete-many'   => DeleteMany::class,
            'add-row'       => AddRow::class,
            'update-row'      => UpdateRow::class,
            'find-item'      => FindItem::class,
            'delete-row'        => DeleteRow::class,
            'auto-increment'   => AutoIncrement::class,
            'save-comment'          => SaveComment::class,
            'show-comment-modal'    => ShowCommentModal::class,
        ]);
    }

    public function saveModel()
    {
        $isNewRecord = $this->model->isNewRecord;

        // 1a. read post data in request
        $postData = Yii::$app->request->post();
        // 1b. check if post request has data
        if ( $postData )
        {
            // 2a. load main form data
            $this->model->load( $postData, $this->model->formName() );
            // 2b. check if file upload is supported in model
            if ( $this->model->allowFileUpload() && isset( $this->model->{ $this->model->fileAttribute } ))
            {
                $filePath = Uploader::getFile( $this->model );
                if ( $filePath )
                    $this->model->{ $this->model->fileAttribute } = $filePath;
            }
            // 3. validate the main form data and tabular data
            if ( $this->model->validate() )
            {
                // 4c. save all post data and log changes
                if ( $this->model->save( false ))
                {
                    // 4e. prepare the success flash message
                    $flashMsg = $this->viewName() . ' : #' . $this->model->id .' '. 'was saved successfully';
                    $success = Yii::t( 'app', '{flashMsg}', [ 'flashMsg' => $flashMsg ]);
                    Yii::$app->session->setFlash( 'success', $success );

                    // 4f. return or redirect to allow further edit if settings apply
                    if ( Yii::$app->request->isAjax )
                        return $this->asJson([ 'success' => true ]);
                    // else
                    return $this->redirect(['index']);
                }
                else {
                    // save error occurred - most likely in the DB
                    $flashMsg = $this->viewName() . ' : ' . 'could not be saved';
                    $error = Yii::t( 'app', '{flashMsg}', [ 'flashMsg' => $flashMsg ]);
                    if ( Yii::$app->request->isAjax )
                        return $this->asJson([ 'failed' => true, 'error' => $error ]);
                    // else
                    Yii::$app->session->setFlash( 'error', $error );
                    // !! refresh to reload attributes
                    // $this->model->refresh();
                }
                // nothing changed go back
            }
            else {
                // validation error occurred
                if ( Yii::$app->request->isAjax )
                {
                    $result = [];
                    foreach ( $this->model->getErrors() as $attribute => $errors )
                        $result[ Html::getInputId( $this->model, $attribute ) ] = $errors;

                    if (!empty($this->validationErrors))
                        array_push( $result, $this->validationErrors );
                    return $this->asJson([ 'validation' => $result ]);
                }
                // else
                Yii::$app->session->setFlash( 'errors', $this->model->errors );
                if (!empty($this->validationErrors))
                    Yii::$app->session->setFlash( 'errors', $this->validationErrors );
            }
        }
        // nothing happened go back
        return $this->loadView();
    }

    public function loadView()
    {
        // 1. load default values for form
        $this->model->loadDefaultValues();
        // !! To-Do: implement $this->loadDetailModelsDefaultValues();

        // 2. render view by request type and action id
        $data = [
            'model' => $this->model,
        ];
        if ( Yii::$app->request->isAjax )
            return $this->renderAjax( $this->formView(), $data );
        // else
        return $this->render( $this->formView(), $data );
    }

    protected function findModel( $id )
    {
        $modelClass = $this->modelClass();
        if (( $this->model = $modelClass::findOne( $id )) !== null )
            return $this->model;

        throw new NotFoundHttpException(
                    Yii::t('app', $this->viewName() . ': #' . $id . ' was not found.')
                );
    }

    // ViewInterface
    public function defaultActionViewType()
    {
        return Type_View::List;
    }

    // CrudInterface
    public function redirectOnCreate()
    {
        return $this->redirect(['update']);
    }

    public function viewCreated(): bool
    {
        return false;
    }

    public function redirectOnUpdate()
    {
        return $this->redirect(['index']);
    }

    public function viewUpdated(): bool
    {
        return false;
    }

    public function redirectOnDelete()
    {
        return $this->redirect(['index']);
    }

    public function linkedModels(): array
    {
        return [];
    }

    public function isReadonly(): bool
    {
        return $this->action->id == 'read';
    }

    public function formView(string $action = null, string $path = null)
    {
        return '@appMain/views/crud/index';
    }

    public function commentView(): string
    {
        return '@appMain/views/_layouts/_comments';
    }
}
