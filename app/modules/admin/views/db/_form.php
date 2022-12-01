<?php

use crudle\app\admin\models\Collation;
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