<?php

use yii\helpers\Html;

$controller = $this->context;

// use button group here
foreach($controller->viewActions() as $viewAction) :
    echo $this->renderFile($controller->viewPath . '/_action/' . $viewAction . '.php');
endforeach;
// use dropdown menu here
if($controller->showBatchActions()) :
    echo $this->renderFile($controller->viewPath . '/_menu/batch.php');
endif;

if ($controller->showViewTypeSwitcher())
    echo $this->render('_actions/view_switcher');

echo Html::a(Yii::t('app', $controller->mainAction()['label']), [$controller->mainAction()['route']], ['class' => 'compact small primary ui button']);

$this->registerJs(<<<JS
    $('#delete_btn').on('click', function(e) {
        // keys is an array of the keys from the selected rows
        keys = $('.grid-view').yiiGridView('getSelectedRows');
        id_list = JSON.stringify(keys);
        delete_url = $(this).attr('href');
        data = {'id_list': id_list};
        confirmDelete(delete_url, data);
        return false; // this prevents the browser dialog from being loaded.
    });

    if (window.location.search) {
        $('.filters').show();

        $('#hide_filters').show();
        $('#show_filters').hide();
    }

    $('.filter.button').on('click', function(e) 
    {
        $('.filters').toggle();

        if (e.target.id == 'show_filters') {
            $(this).hide();
            $('#hide_filters').show();
        }
        if (e.target.id == 'hide_filters') {
            $(this).hide();
            $('#show_filters').show();
        }
    });
JS);