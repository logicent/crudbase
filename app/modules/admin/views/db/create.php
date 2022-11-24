<?php

$this->title = Yii::t('app', 'Create database');

echo $this->render('/_form/index', [
    'viewPath' => '/db/_form'
]);