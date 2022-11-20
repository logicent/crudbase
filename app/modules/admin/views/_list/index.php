<?php

use yii\helpers\Inflector;

$context = $this->context;
$module = $this->context->module;

$this->title = Yii::t('app', 'Database: ') . $formModel->schemaName;
echo $this->render('/_view/_breadcrumb');
$this->params['breadcrumbs'][] = ['label' => $formModel->schemaName];

$searchForm = $context->viewPath . '/_search.php';
if (file_exists($searchForm)) : ?>
    <div style="display: none;" id="list_header" class="ui basic segment filters">
        <?= $this->render('_search', ['searchModel' => $searchModel]) ?>
    </div>
<?php endif;

$checkboxColumn = require Yii::getAlias('@appMain/views/list/_checkboxColumn.php');
$actionColumn = require '_actionColumn.php';

echo
    $this->render('GridView', [
        'dataProvider'  => $dataProvider, 
        'checkboxColumn'=> $checkboxColumn,
        'actionColumn'  => $actionColumn,
        'columns'       => $columns,
    ]);