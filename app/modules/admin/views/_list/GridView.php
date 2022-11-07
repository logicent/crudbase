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

<div class="ui bottom attached padded segment">
<?php
    echo GridView::widget([
        'layout' => "{items}\n{pager}",
        'tableOptions' => [
            'class' => 'ui very basic table'
        ],
        'caption' => isset($caption) ? $caption : null,
        'captionOptions' => [
            'class' => 'ui left aligned small secondary header basic segment text-muted',
            'style' => 'font-weight: 500'
        ],
        'dataProvider' => $dataProvider,
        'columns'  => ArrayHelper::merge(
            [
                [
                    'class' => 'icms\FomanticUI\widgets\CheckboxColumn',
                    'header' => Checkbox::widget([
                        'name' => 'select_row',
                        // 'checked' => false, // default false
                    ]),
                    // 'headerOptions' => [
                    //     'id' => 'select_all_rows'
                    // ],
                    // 'content' => function ($model, $key, $index, $column) {
                    //     return Checkbox::widget([
                    //         'name' => $key
                    //     ]);
                    // },
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return [
                            'class' => 'select-row',
                            'id' => $index,
                            'value' => Json::encode($key),
                        ];
                    },
                    // 'contentOptions' => [
                    // ],
                    // 'visible' => false
                ],
            ],
            $columns,
        ) // array merge
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
</div>