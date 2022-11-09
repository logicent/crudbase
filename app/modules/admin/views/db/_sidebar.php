<div class="ui basic padded segment" style="padding: 1.5em 1em; font-size: 92.5%; color: #555;">
    <?= Yii::t('app', 'MySQL version: ') ?>
    <b><?= Yii::$app->db->getServerVersion() ?></b>
    <?= Yii::t('app', ' through PHP extension ') ?>
    <b>pdo_mysql</b>
</div>