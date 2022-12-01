<?php

use yii\helpers\ArrayHelper;
use icms\FomanticUI\widgets\GridView;
use crudle\app\assets\DataTable;

DataTable::register($this);
    echo GridView::widget([
        // 'caption' => isset($caption) ? $caption : null,
        // 'captionOptions' => [
        //     'class' => 'ui left aligned small secondary header basic segment text-muted',
        //     'style' => 'font-weight: 500'
        // ],
        'emptyText' => Yii::t('app', 'No rows found'),
        'emptyTextOptions' => ['class' => 'ui small header center aligned text-muted'],
        'layout' => "{summary}\n{items}\n{pager}\n{errors}", // {sorter}
        'summary' => 'Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> rows.',
        'summaryOptions' => ['class' => 'text-muted', 'style' => 'text-align: right;'],
        'tableOptions' => ['class' => 'ui striped selectable single line primary table'],
        'dataProvider' => $dataProvider,
        'columns' => ArrayHelper::merge(
            $checkboxColumn,
            isset($this->params['actionColumn']) ? $this->params['actionColumn'] : [],
            $columns,
        ) // array merge
    ]);
?>

<?php
$this->registerJs(<<<JS
    // $(document).on('pjax:send', function() {
    //     $('#loading').show()
    // })
    $(document).on('pjax:complete', function() {
        if (window.location.search) {
            $('.filters').show();

            $('#hide_filters').show();
            $('#show_filters').hide();
        }
        // $('#loading').hide()
    })

    $('.grid-view').on('click', '.ui.checkbox',  function(e) 
    {
        el_select_all_rows = $(this).find('.select-on-check-all');
        if (el_select_all_rows.prop('checked'))
        {
            $('.ui.table > tbody > tr').css('background', 'aliceblue');
        }
        else {
            $('.ui.table > tbody > tr').css('background', 'none');
        }
    });

    $('.grid-view').on('click', '#select_all_rows', function(e) 
    {
        el_select_all_rows = $(this).find('input');
        el_select_rows = $(this).closest('table').find('tbody td.select-row');
        el_select_rows.each(function(i) {
            input = $(this).find('input');
            if (el_select_all_rows.prop('checked')) {
                input.prop('checked', true);
                $(this).closest('tr').css('background', 'aliceblue');
                $('#delete_btn').show();
                $('#create_btn').hide();
            }
            else {
                input.prop('checked', false);
                $(this).closest('tr').css('background', 'none');
                if ($('.ui.checkbox.checked').length == 0) {
                    $('#delete_btn').hide();
                    $('#create_btn').show();
                }
            }
        });
    })

    $('.grid-view').on('click', '.ui.checkbox', function(e) 
    {
        el_select_rows = $(this).closest('tbody').find('td.select-row');
        el_select_rows.each(function(i) {
            input = $(this).find('input');
            if (input.prop('checked')) {
                $(this).closest('tr').css('background', 'aliceblue');
                $('#delete_btn').show();
                $('#create_btn').hide();
            }
            else {
                $(this).closest('tr').css('background', 'none');
                // check for count of other selected rows
                if ($('.ui.checkbox.checked').length == 0) {
                    $('#delete_btn').hide();
                    $('#create_btn').show();
                }
            }
        });
    })
JS);