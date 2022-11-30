<?php

$this->title = Yii::t('app', 'Table: ') . Yii::$app->request->queryParams['TABLE_NAME'];
echo $this->render('/_view/_breadcrumb');
$this->params['breadcrumbs'][] = ['label' => $formModel->schemaName];
?>

<?= $this->render('/_list/index', [
        'searchModel'   => $searchModel,
        'dataProvider'  => $dataProvider,
        'formModel'     => $formModel,
        'columns'       => $columns,
        'tablePK'       => $tablePK,
]);