<?php

use crudle\app\admin\enums\Db_Driver;
use icms\FomanticUI\Elements;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Database Connection');

$options = [
    'options' => ['class' => 'inline field'],
    'labelOptions' => ['style' => 'font-size: 16px; font-weight: normal; width: 160px;'],
    'inputOptions' => ['style' => 'font-size: 16px; width: 330px;']
];
?>
<div class="ui attached padded segment">
    <!-- <div class="ui error message"> -->
        <!-- <div class="header"><?= Yii::t('app', 'Validation error(s)') ?></div> -->
        <?php /*
            if (isset($model->errors['dsn'])) :
                foreach ($model->errors['dsn'] as $error) :
                    echo Html::tag('p', Elements::icon('mini dot circle') . $error);
                endforeach;
            endif */ ?>
    <!-- </div> -->
    <?= $form->field($model, 'driver', $options)->dropDownList(
            Db_Driver::enums(),
            ['style' => 'width: 330px']
        ) ?>
    <?= $form->field($model, 'dsn')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'host', $options)->textInput([
            'maxlength' => 140,
            'placeholder' => Yii::t('app', 'localhost')
        ]) ?>
    <?= $form->field($model, 'port', $options)->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'username', $options)->textInput([
            'maxlength' => 140,
            'autofocus' => true
        ]) ?>
    <?= $form->field($model, 'password', $options)->passwordInput(['maxlength' => 140]) ?>
    <?= $form->field($model, 'database', $options)->textInput(['maxlength' => 140]) ?>
    <div style="text-align: right;">
        <?= $form->field($model, 'rememberMe', $options)->checkbox([
                'class' => 'right aligned toggle',
                'style' => 'font-size: 16px;'
            ])->label('&nbsp;') ?>
    </div>
</div>

<div class="ui bottom secondary attached right aligned padded segment">
    <?= Html::submitButton('Log in', [
            'class' => 'compact ui large primary button', 
            'name' => 'login-button',
            'style' => 'margin-right: 0em'
        ]) ?>
</div>