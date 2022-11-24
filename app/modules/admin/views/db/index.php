<?php

$this->title = Yii::t('app', 'Database');
echo $this->render('/_view/_breadcrumb');
$this->params['breadcrumbs'][] = ['label' => $formModel->schemaName];
?>

<?= $this->render('@appMain/views/list/index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
]);