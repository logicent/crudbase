<?php

use icms\FomanticUI\Elements;
use yii\helpers\Url;

$model = $this->context->getModel();

echo Elements::button(Yii::t('app', 'Submit'), [
    'class' => 'compact primary',
    'id'    => 'submit_btn',
    'data' => [
        'method' => 'post',
        'confirm' => Yii::t('app', 'Are you sure you want to Cancel?'),
        'url' => Url::to(['submit', 'id' => $model->id])
    ]
]);
