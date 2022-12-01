<?php

$this->title = Yii::t('app', 'Alter database');

echo $this->render('/_form/index', [
    'model' => $model,
    'viewPath' => '/db/_form'
]);