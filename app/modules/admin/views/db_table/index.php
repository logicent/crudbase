<?php

$this->title = Yii::t('app', 'Database: ') . $formModel->schemaName;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', '{dbServer}', ['dbServer' => 'MySQL']), // fetch the server name in context
    'url' => ['/app/db-server']
];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Server'), 'url' => ['/app/db-list']];
$this->params['breadcrumbs'][] = ['label' => $formModel->schemaName];
?>

<?= $this->render('@appMain/views/list/index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
]);