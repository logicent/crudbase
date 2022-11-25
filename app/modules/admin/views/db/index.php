<?php

$this->title = Yii::t('app', 'Database');
echo $this->render('/_view/_breadcrumb');
?>

<?= $this->render('@appMain/views/list/index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
]);