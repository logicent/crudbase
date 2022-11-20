<?php

// $this->title = Yii::t('app', 'Table: ') . $formModel->tableName;
$this->title = Yii::t('app', 'Database: ') . $formModel->schemaName;
echo $this->render('/_view/_breadcrumb');
$this->params['breadcrumbs'][] = ['label' => $formModel->schemaName];
?>

<?= $this->render('/_list/index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'formModel' => $formModel,
        'columns' => $columns,
]);