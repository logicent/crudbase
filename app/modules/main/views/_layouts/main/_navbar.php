<?php

use yii\helpers\Html;
use icms\FomanticUI\collections\Breadcrumb;
use icms\FomanticUI\Elements;

?>

<?php $this->beginBlock('@appMain/views/_layouts/main/_navbar') ?>

<header class="main-container">
    <nav class="main-head ui menu text">
        <div class="item" id="menu_icon">
            <?= Html::a(Elements::icon('sidebar large'), ['#'],
                    [
                        'id' => 'main_menu',
                        'style' => 'position: fixed; padding-left: 0.65em; color: grey; background: none;'
                    ]) ?>
        </div>
        <div class="ui three column grid container">
            <div class="one wide column item" id="home_icon">
            <!-- $layoutSettings->homeButtonIcon -->
                <?= Html::a(Elements::icon('brown globe large'), false, ['class' => "compact ui icon button"]) ?>
            </div>
            <div class="computer only large screen only five wide column item">
            <?php
                if ($this->context->id !== 'main') :
                    echo Breadcrumb::widget([
                            'divider' => Breadcrumb::DIVIDER_CHEVRON,
                            'homeLink' => [
                                'label' => '', // sets divider only to point back to home icon button
                            ],
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]);
                endif ?>
            </div>
            <div class="computer only large screen only ten wide column item">
            <?php
                // echo $this->render('../_nav/_menu_create');
                echo $this->render('../_nav/_search_input');
                echo $this->render('../_nav/_menu_help');
                echo $this->render('../_nav/_menu_user') ?>
            </div>
        </div><!-- ./ui three column grid -->
    </nav>
</header>

<?php $this->endBlock();