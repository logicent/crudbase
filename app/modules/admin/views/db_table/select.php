<?php

$this->title = Yii::t('app', 'Table: ') . Yii::$app->request->queryParams['TABLE_NAME'];
echo $this->render('/_view/_breadcrumb');
$this->params['breadcrumbs'][] = ['label' => $formModel->schemaName];
$this->params['tablePK'] = $tablePK;
$this->params['actionColumn'] = require Yii::getAlias('@appAdmin/views/_list/_action/edit.php');
?>

<?= $this->render('/_list/index', [
        'searchModel'   => $searchModel,
        'dataProvider'  => $dataProvider,
        'formModel'     => $formModel,
        'columns'       => $columns,
]);