<?php

$this->title = Yii::t('app', 'Structure: '); // . $formModel->schemaName;
echo $this->render('/_view/_breadcrumb');
// $this->params['breadcrumbs'][] = ['label' => $formModel->schemaName];
?>

<?= $this->render('/_list/index', [
        'dataProvider' => $dataProvider,
        'columns' => $columns,
]);