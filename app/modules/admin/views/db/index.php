<?php

$this->title = Yii::t('app', 'Database List');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', '{dbServer}', ['dbServer' => 'MySQL']), // fetch the server name in context
    'url' => ['/app/db-server']
];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Server')];
?>

<?= $this->render('@appMain/views/list/index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
]);