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
                if ($controller->mapActionViewType() == Type_View::Form && $controller->action->id !== 'read') :
                    // new or update record and settings form view
                    echo $this->render('@appMain/views/_form/_view_header');
                elseif ($controller->mapActionViewType() == Type_View::List) :
                    // all multiple record views like list view
                    if ($controller->showViewTypeSwitcher())
                        echo $this->render('_view_type');
                    echo $this->render('@appMain/views/list/_view_header');
                endif ?>
                </div>
            </div>
        </div>
    </nav>
</header>