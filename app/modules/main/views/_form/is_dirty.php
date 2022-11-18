<?php

use crudle\app\assets\Dirrty;

Dirrty::register($this);
?>

<!-- If form is dirty !!! then show reminder to save -->
<span class="app-status-label app-hidden">
    <i class="ui mini yellow empty circular label"></i>
    &ensp;<?= Yii::t('app', 'Not saved') ?>&ensp;
</span>

<?php
$this->registerJs(<<<JS
    $('.ui.form').dirrty({
        preventLeaving : false,
        // leavingMessage: 'Your unsaved changes will be lost', // ignored by browser and overridden
    }).on('dirty',
        function() {
            $('.app-status-label').toggleClass('app-hidden');
            // switch primary action button
            if ($('#submit_btn').length == 1) {
                $('#save_btn').show();
                $('#submit_btn').hide();
            }
    }).on('clean',
        function() {
            $('.app-status-label').toggleClass('app-hidden');
            // switch primary action button
            if ($('#submit_btn').length == 1) {
                $('#submit_btn').show();
                $('#save_btn').hide();
            }
    });

    $('#save_btn').on('click', function(e) {
        $('.ui.form button[type="submit"]').click();
    });

    $('#submit_btn').on('click', function(e) {
        url = $(this).data('url');
        confirmAction(url);
        return false; // this prevents the browser dialog from being loaded.
    });
JS);