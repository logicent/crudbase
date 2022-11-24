<?php

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', '{dbServer}', ['dbServer' => 'MySQL']), // fetch the server name in context
    // 'url' => ['/admin/server']
];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Server'),
    'url' => ['/admin/db']
];
