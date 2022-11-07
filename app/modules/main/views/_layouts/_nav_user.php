<?php

use yii\helpers\Html;
use icms\FomanticUI\Elements;


$username = Yii::$app->session->get('dbConfig')['username'];
$host = Yii::$app->session->get('dbInfo')['host'];
?>
<div class="ui dropdown item right">
<?php
    if (Yii::$app->session->has('dbConfig')) :
        echo $username . '@' . $host;
    endif
?>&ensp;
    <?= Elements::icon('down small chevron') ?>
    <div class="menu nav-menu">
        <?= Html::a(Yii::t('app', 'Log out'),
                    ['/app/logout'], [
                        'class' => 'item',
                        'data' => ['method' => 'post']
                    ]) ?>
    </div><!-- ./menu -->
</div><!-- ./dropdown item -->