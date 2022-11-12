<?php

$controller = $this->context;

/* foreach($controller->viewActions() as $viewAction) :
    echo $this->render('_action/' . $viewAction['actionId']);
endforeach;
*/
// if ($controller->showViewTypeSwitcher())
//     echo $this->render('_actions/view_switcher');

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