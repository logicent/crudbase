<?php

use yii\helpers\Inflector;

$context = $this->context;
$module = $this->context->module;

$searchForm = $context->viewPath . '/_search.php';
if (file_exists($searchForm)) : ?>
    <div style="display: none;" id="list_header" class="ui basic segment filters">
        <?= $this->render('_search', ['searchModel' => $searchModel]) ?>
    </div>
<?php endif;

echo
    $this->render('SimpleGridView', [
        'dataProvider'  => $dataProvider, 
        'columns'       => $columns,
    ]);