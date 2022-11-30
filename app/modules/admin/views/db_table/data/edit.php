<?php

$this->title = Yii::t('app', 'Edit: ') . $tableDef->name;

echo $this->render('_form', [
    'model' => $model,
    'tableDef' => $tableDef,
]);