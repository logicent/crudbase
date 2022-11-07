<?php

namespace crudle\app\main\enums;


class Type_View
{
    const Workspace = 'Workspace';
    const List      = 'List';
    const Form      = 'Form';
    const Tree      = 'Tree';

    public static function enums()
    {
        return [
            self::Workspace => [
                'icon' => 'window maximize outline',
                'label' => 'Workspace',
                'color' => '',
                'link' => '#workspace',
                'action' => ['index'],
            ],
            self::List => [
                'icon' => 'list',
                'label' => 'List',
                'color' => '',
                'link' => '#list',
                'action' => ['index'],
            ],
            self::Form => [
                'icon' => 'columns',
                'label' => 'Form',
                'color' => '',
                'link' => '#form',
                'action' => ['create', 'update', 'read'],
            ],
            self::Tree => [
                'icon' => 'sitemap',
                'label' => 'Tree',
                'color' => '',
                'link' => '#tree',
                'action' => ['index'],
            ],
        ];
    }
}