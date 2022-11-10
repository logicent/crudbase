<?php

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', '{dbServer}', ['dbServer' => 'MySQL']), // fetch the server name in context
    'url' => ['/app/db-server']
];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Server')];