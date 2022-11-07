<?php

use yii\helpers\Html;
use yii\helpers\Url;
use icms\FomanticUI\Elements;


$menuItems = [
    [
        // 'icon' => 'grey download large',
        'route' => 'db-view',
        'label' => 'View',
        'inactive' => false,
    ],
    [
        // 'icon' => 'grey download large',
        'route' => 'db-table',
        'label' => 'Table',
        'inactive' => false,
    ],
];
?>

<div class="ui dropdown item">
    <span class="text" style="font-size: 140%">+</span>&nbsp;
    <span class="text"><?= Yii::t('app', 'Create') ?></span>&ensp;
    <?= Elements::icon('down small chevron') ?>
    <div class="menu nav-menu" style="margin-top: 1em !important;">
    <?php
        foreach ($menuItems as $menuItem) :
            if ((bool) $menuItem['inactive']) :
                continue;
            endif;
            // echo Html::a(Elements::icon($menuItem['icon'] .' '. $menuItem['iconColor']) . Yii::t('app', '{menuItem}', ['menuItem' => $menuItem['label']]),
            echo Html::a(Yii::t('app', '{menuItem}', ['menuItem' => $menuItem['label']]),
                        Url::to([$menuItem['route']. '/create']),
                        ['class' => 'item']);
        endforeach ?>
    </div>
</div>&ensp;