<?php

use crudle\app\helpers\DateTimeHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use icms\FomanticUI\widgets\GridView;
use icms\FomanticUI\Elements;
use crudle\app\assets\DataTable;
use crudle\app\helpers\StatusMarker;
use yii\helpers\Json;
use icms\FomanticUI\modules\Checkbox;

DataTable::register($this);
?>

<?php
    echo GridView::widget([
        // 'caption' => isset($caption) ? $caption : null,
        // 'captionOptions' => [
        //     'class' => 'ui left aligned small secondary header basic segment text-muted',
        //     'style' => 'font-weight: 500'
        // ],
        'layout' => "{summary}\n{items}\n{pager}\n{errors}", // {sorter}
        'summary' => 'Showing <b>{begin} - {end}</b> of <b>{totalCount}</b> rows.',
        'summaryOptions' => ['class' => 'text-muted', 'style' => 'text-align: right;'],
        'tableOptions' => ['class' => 'ui striped selectable fixed single line primary table'],
        'dataProvider' => $dataProvider,
        // 'columns' => ArrayHelper::merge(
        //     $checkboxColumn,
            // $linkColumn,
            // $columns,
        // ) // array merge
    ]);
$this->registerJs(<<<JS
    // if ($('.ui .table > tbody > tr').length > 1) {
    //     $('.ui .table').DataTable({
    //         stateSave: true,
    //     });
    // }

    // $('.grid-view').on('click', '.ui.checkbox', function(e) 
    // {
    //     el_select_row = $(this).find(':checkbox');
    //     if (el_select_row.prop('checked'))
    //     {
    //         $('#delete_btn').show();
    //         $('#create_btn').hide();
    //     }
    //     else {
    //         // check for count of other selected rows
    //         if ($('.ui.checkbox.checked').length == 0)
    //         {
    //             $('#delete_btn').hide();
    //             $('#create_btn').show();
    //         }
    //     }
    // });
JS)
?>