<?php

namespace crudle\app\admin\forms;

use yii\base\DynamicModel;

class TableRecord extends DynamicModel
{
    public function defineAttributes($attributeNames)
    {
        foreach ($attributeNames as $attributeName)
            $this->defineAttribute($attributeName);
    }

    public function setValuesByAttribute($row)
    {
        foreach ($row as $column => $value)
            $this->{$column} = $value;
    }
}