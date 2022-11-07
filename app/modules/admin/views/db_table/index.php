<?php

$this->title = Yii::t('app', 'Table');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', '{dbServer}', ['dbServer' => 'MySQL']), // fetch the server name in context
    'url' => ['/app/db-server']
];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Server'), 'url' => ['/app/db-list']];
$this->params['breadcrumbs'][] = ['label' => '{{DATABASE_NAME}}'];
?>

<?= $this->render('@appMain/views/list/index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
]);