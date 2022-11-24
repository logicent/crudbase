<?php

use yii\helpers\Html;
use icms\FomanticUI\Elements;

$this->title = $name;
$username = Yii::$app->session->has('dbConfig') ? Yii::$app->session->get('dbConfig')['username'] : null;
$host = Yii::$app->session->has('dbInfo') ? Yii::$app->session->get('dbInfo')['host'] : null;
if (Yii::$app->session->has('dbConfig')) :
    $dbUser = $username . '@' . $host;
else :
    $dbUser = null;
endif
?>

<div class="site-error">
    <!-- <div class="ui divider hidden"></div> -->
    <div class="ui basic segment">
        <!-- <i class="close icon"></i> -->
        <div class="ui header">
            <!-- <?= Elements::icon('warning', ['class' => 'mini']) ?> -->
            <?= Html::encode($this->title) ?>
        </div>
        <p>
            <?= nl2br(Html::encode($message)) ?>
        </p>
        <div class="ui hidden divider"></div>
        <div>
            Hi <?= $dbUser ?>,
        </div>
        <br>
        <!-- ToDo: allow user to customize this message in layout settings -->
        <p class="description">
            <?= Yii::t('app', "
                Sorry, the above error occurred while <b>". Yii::$app->params['appName'] . "</b> was processing your request.
                <br><br>
                Please open a support ticket on the issue for quick resolution") ?>
        </p>
        <!-- TODO: Add the ability to send the error report to support mail or System Manager/Administrator -->
        <!-- Please send this error report to your System Manager.<br> -->
        <!-- ToDo: allow user to set this redirection route and whether it is automatic after mail is sent -->
        <?= Html::a('Go Home', ['/admin/server'], ['class' => 'compact ui small primary button']) ?>
    </div>
</div>