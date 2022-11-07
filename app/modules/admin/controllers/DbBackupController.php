<?php

namespace crudle\app\admin\controllers;

use crudle\app\setup\controllers\base\BaseSettingsController;
use crudle\app\main\enums\Type_Model;
use crudle\app\main\enums\Type_Relation;
use crudle\app\helpers\DbDumper;
// use crudle\app\helpers\DbRestore;
use crudle\app\main\models\auth\Auth;
use crudle\app\setup\models\DbBackupSettingsForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;

class DbBackupSettingsController extends BaseSettingsController
{
    public $backups;

    public function init()
    {
        $this->backups = FileHelper::findFiles(Yii::getAlias('@app/../storage/backups'), [
            'except' => ['.gitignore']
        ]);
        return parent::init();
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'db-dump', 'db-restore', 'clear-dump', 'delete-all'],
                'rules' => [
                    [
                        'actions' => ['index', 'db-dump', 'db-restore', 'clear-dump'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['delete-all'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionDbDump()
    {
        $result = DbDumper::createDbDump();

        if ($result === true) // dump succeeded
            return Yii::t('app', 'Database backup was created successfully');
        else // dump failed
            return $result; // Yii::t('app', 'Failed to create the database backup');
    }

    public function actionDbRestore()
    {
        // fetch uploaded or selected DB dump file
        // make a DB dump call before restore task
        // make a DB restore if applicable and return errors
        $result = '';
        if ($result === true) // restore succeeded
            return Yii::t('app', 'Database restore was completed successfully');
        else // restore failed
            return $result; // Yii::t('app', 'Failed to perform or complete the database restore');
    }

    public function actionClearDump()
    {
        $succeeded = true;
        foreach ($this->backups as $backup) {
            $succeeded = FileHelper::unlink( $backup ) && $succeeded;
        }
        if ($succeeded)
            return Yii::t('app', 'Database dumps cleared successfully');
        // else
        return Yii::t('app', 'Failed: Database dumps could not be cleared');
    }

    public function actionDeleteAll()
    {
        if ( Yii::$app->request->isAjax )
        {
            // Create a DB dump before performing delete all
            DbDumper::createDbDump();

            // Get a list of deletable resources
            $modelClasses = Type_Model::modelClasses();

            foreach ( $modelClasses as $modelClass )
            {
                $transaction = $modelClass::getDb()->beginTransaction();
                try {
                    foreach ( $modelClass::relations() as $relationId => $relationClass )
                    {
                        if ( is_array( $relationClass )) {
                            if ($relationClass['type'] == Type_Relation::InlineModel)
                                continue;
                            $relationClass['class']::deleteAll();
                        }
                        else
                            $relationClass::deleteAll();
                    }

                    $modelClass::deleteAll();

                    $transaction->commit();
                } 
                catch(\Throwable $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }

            $transaction = Auth::getDb()->beginTransaction();
            try {

                $transaction->commit();
            }
            catch(\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->redirect(['/setup']);
    }

    // Interface
    public function modelClass(): string
    {
        return DbBackupSettingsForm::class;
    }
}
