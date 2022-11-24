<?php

$this->title = Yii::t('app', 'Alter database');

echo $this->render('/_form/index', [
    'viewPath' => '/db/_form'
]);