<?php

namespace crudle\app\admin\controllers\action;

use Yii;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\StringHelper;

class Select extends Action
{
    public function run()
    {
        if (!Yii::$app->session->has('dbConfig'))
            return $this->controller->redirect(['/app/login']);

        $baseTableInfo = $this->controller->modelClass()::find()->where(['TABLE_NAME' => Yii::$app->request->queryParams['TABLE_NAME']])->one();
        $tableSchema = $baseTableInfo->TABLE_SCHEMA;
        $baseTable = $tableSchema .'.'. Yii::$app->request->queryParams['TABLE_NAME'];
        $query = (new Query())->from($baseTable);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $formModelClass = $this->controller->formModelClass();
        $this->controller->formModel = new $formModelClass;
        $this->controller->formModel->schemaName = $tableSchema;

        $searchModelClass = $this->controller->searchModelClass();
        $data = [
            'formModel' => $this->controller->formModel,
            'searchModel' => new $searchModelClass(),
            'dataProvider' => $dataProvider,
        ];
        if (Yii::$app->request->isAjax)
            return $this->controller->renderAjax('@appAdmin/views/_list/index', $data);
        else
            return $this->controller->render('@appAdmin/views/_list/index', $data);
    }
}
