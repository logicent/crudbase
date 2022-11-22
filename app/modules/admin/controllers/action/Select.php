<?php

namespace crudle\app\admin\controllers\action;

use crudle\app\main\controllers\base\BaseAction;
use Yii;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\db\mysql\Schema;
use yii\db\Query;
use yii\helpers\StringHelper;

class Select extends BaseAction
{
    public function run()
    {
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
            'columns' => $this->_getTableColumns($baseTable),
            'formModel' => $this->controller->formModel,
            'searchModel' => new $searchModelClass(),
            'dataProvider' => $dataProvider,
        ];
        $headers = Yii::$app->request->headers;
        $isAjaxRequest = Yii::$app->request->isAjax || $headers->has('HX-Request');
        if ($isAjaxRequest) // renderAjax
            return $this->controller->render('/_listindex', $data);
        else
            return $this->controller->render('/_list/index', $data);
    }

    private function _getTableColumns($tableSchema)
    {
        $schema = Yii::$app->db->schema->getTableSchema($tableSchema);

        return array_keys($schema->columns);
    }
}
