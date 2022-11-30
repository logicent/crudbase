<?php

$this->title = Yii::t('app', 'New entry: ') . $tableDef->name;

echo $this->render('_form', [
    'model' => $model,
    'tableDef' => $tableDef,
]);