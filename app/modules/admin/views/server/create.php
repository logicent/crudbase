<?php

use crudle\app\admin\models\Collation;

$this->title = Yii::t('app', 'Create Database');
// $this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="ui segment">
    <div class="ui two column grid">
        <div class="column">
            <?= $form->field($model, 'schemaName') ?>
        </div>
        <div class="column">
            <?= $this->render('@appMain/views/_form_field/select', [
                'model' => $model,
                'form' => $form,
                'attribute' => 'collation',
                'list' => [
                    'modelClass' => Collation::class,
                    'keyAttribute' => 'COLLATION_NAME',
                    'valueAttribute' => 'COLLATION_NAME',
                    'groupAttribute' => 'CHARACTER_SET_NAME',
                    // 'addEmptyFirstItem' => true,
                    'filters' => []
                ]
            ]) ?>
        </div>
    </div>
</div>