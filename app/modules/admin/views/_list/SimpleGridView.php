<?php

use icms\FomanticUI\widgets\GridView;
use crudle\app\assets\DataTable;

DataTable::register($this);
?>

<div class="ui segment">
    <?= GridView::widget([
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
        'tableOptions' => ['class' => 'very basic ui fixed single line table'],
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]) ?>
</div>

<?php
$this->registerJs(<<<JS
    // $('.ui.table').DataTable({

    // });
JS);