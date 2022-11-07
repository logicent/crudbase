<?php

// use crudle\app\setup\models\GeneralSettingsForm;
// use crudle\app\setup\models\Setup;
use yii\helpers\Html;
use yii\helpers\Inflector;
use icms\FomanticUI\Elements;
use icms\FomanticUI\widgets\ActiveForm;

$subView = Inflector::underscore(Inflector::id2camel($this->context->action->id));
?>

<div class="login-wrapper">

<?php
$form = ActiveForm::begin([
        'id' => $this->context->action->id . '-form',
        'enableClientValidation' => false,
        'options' => [
            'autocomplete' => 'off',
            'class' => 'ui form', // error
        ],
    ]);

    $fieldInputs = $this->render('_' . $subView, ['form' => $form, 'model' => $model]);
?>

<div class="ui centered grid">
    <div class="eight wide computer eight wide tablet sixteen wide mobile column">
        <div class="login">
            <div class="ui top secondary attached padded segment">
                <div class="ui centered large header" style="color: #6c7680; font-weight: normal;">
                    <?= Elements::icon('database', ['class' => 'brown'] ) ?>
                    <?= Html::encode($this->title) ?>
                </div>
            </div>
            <?= $fieldInputs ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
</div>

<?php $this->registerCssFile("@web/css/login.css");