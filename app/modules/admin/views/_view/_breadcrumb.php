<?php

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', '{dbServer}', ['dbServer' => 'MySQL']), // fetch the server name in context
    'url' => ['/app/server']
];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Server'), 'url' => ['/app/server']];
