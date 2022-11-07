<?php

namespace crudle\app\main\controllers\base;

interface ListViewInterface
{
    public function listviewType(); // enum

    public function showBatchActions(): bool;

    public function batchActionsMenu(): array;

    public function showListMenu(): bool;

    public function listMenu(): array;
}