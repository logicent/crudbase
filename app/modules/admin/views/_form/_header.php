<?php

use yii\helpers\Html;

echo Html::submitButton(Yii::t('app', 'Save'), [
        'class' => 'compact ui primary button',
        'style' => 'display: none;'
    ]);

$this->render('@appMain/views/_layouts/_flash_message', ['context' => $this->context]);
