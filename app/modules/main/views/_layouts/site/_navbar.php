<?php

// use crudle\app\setup\models\GeneralSettingsForm;
// use crudle\app\setup\models\Setup;
use yii\helpers\Url;
use yii\helpers\Html;

// $generalSettings = Setup::getSettings( GeneralSettingsForm::class );
?>

<?php $this->beginBlock('@appMain/views/_layouts/site/_navbar') ?>

<div id="site_header">
    <div class="ui attached menu borderless" style="padding: 1em 0em;">
        <div class="ui container">
            <div class="item">
                <div class="ui header text-muted" style="font-weight: 500;">
                    <?= Yii::$app->params['appName'] ?>
                </div>
            </div>
            <div class="right menu">
                <div class="ui dropdown item">
                    <div class="menu">
                        <?= Html::a(Yii::t('app', 'Log out'), ['logout'], [
                                'class' => 'item',
                                'data' => ['method' => 'post']
                            ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endBlock();