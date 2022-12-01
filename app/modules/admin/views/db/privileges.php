<?php

$this->title = Yii::t('app', 'Privileges');
echo $this->render('/_view/_breadcrumb');
$this->params['breadcrumbs'][] = ['label' => $formModel->schemaName];
$this->params['actionColumn'] = require '_action/edit_user.php';
?>

<?= $this->render('/_list/index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'formModel' => $formModel,
        'columns' => $columns,
]);