<?php

use icms\FomanticUI\Elements;

$model = $this->context->getModel();

echo Elements::button(Yii::t('app', 'Save'), [
    'class' => 'compact primary',
    'id'    => 'save_btn',
]);
