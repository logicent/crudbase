<?php

use icms\FomanticUI\widgets\ActiveForm;

$this->title = Yii::t('app', 'SQL Command');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'SQL Command'), 'url' => ['/app/db-cmd']];

$fieldOptions = [
    'options' => ['class' => 'inline field'],
    'labelOptions' => ['style' => 'font-size: 16px; font-weight: normal; width: 160px;'],
    'inputOptions' => ['style' => 'font-size: 16px; width: 330px;']
];
?>

<div class="ui segment">
<?php
$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableClientValidation' => false,
    'options' => [
        'autocomplete' => 'off',
        'class' => 'ui form',
    ],
]);

ActiveForm::end() ?>
</div>