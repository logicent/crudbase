<?php

use crudle\app\helpers\StatusMarker;
use crudle\app\main\enums\Type_View;
use yii\helpers\Html;


$controller = $this->context;

$menuItems = [];
?>

<header class="page-container">
    <nav class="page-head ui attached menu text">
        <div class="ui grid container">
            <div class="ten wide column item">
                <div class="page-title ui floated header">
                    <?= Html::encode($this->title) ?>
                </div>
            </div>
            <div class="six wide column right aligned">
                <div class="page-actions"><!-- ui spaced buttons -->
            <?php
                // new or update record and settings form view
                // if ($controller->viewType() == Type_View::Form) :
                    echo $this->render('@appMain/views/_form/action');
                // other multiple records views like list view
                // elseif ($controller->viewType() == Type_View::List) :
                    echo $this->render('@appMain/views/list/actions');
                // endif ?>
                </div>
            </div>
        </div>
    </nav>
</header>