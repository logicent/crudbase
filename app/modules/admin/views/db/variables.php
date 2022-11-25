<?php

$this->title = Yii::t('app', 'Variables');
echo $this->render('/_view/_breadcrumb');
$this->params['breadcrumbs'][] = ['label' => $formModel->schemaName];
?>

<?= $this->render('/_list/index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'formModel' => $formModel,
        'columns' => $columns,
]);