<?php
use backend\models\Config;
 ?>
<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'НАВИГАЦИЯ', 'options' => ['class' => 'header']],
                    ['label' => 'Страницы', 'icon' => 'pencil', 'url' => ['/pages']],
                    ['label' => 'Сообщения', 'icon' => 'envelope', 'url' => ['/message']],
                    ['label' => 'Заказы', 'icon' => 'th-list', 'url' => ['/order']],
                    ['label' => 'Изготовители', 'icon' => 'industry', 'url' => ['/producer']],
                    ['label' => 'Агенты', 'icon' => 'suitcase', 'url' => ['/agent'],'visible' => Yii::$app->user->can('admin')],
                    ['label' => 'Клиенты', 'icon' => 'users', 'url' => ['/client']],
                    ['label' => 'Цены реализации', 'icon' => 'money', 'url' => '#',
                        'items' => [
                            ['label' => 'Цены на печати', 'icon' => 'list', 'url' => ['/cliche-price'],],
                            ['label' => 'Цены на оснастку', 'icon' => 'list', 'url' => ['/stamp-price'],],
                        ],'visible' => Yii::$app->user->can('admin'),
                    ],
                    ['label' => 'Справочники', 'icon' => 'list', 'url' => '#',
                        'items' => [
                            ['label' => 'Печати', 'icon' => 'list', 'url' => ['/cliche'],],
                            ['label' => 'Оснастка', 'icon' => 'list', 'url' => ['/stamp'],],

                            ['label' => 'Города', 'icon' => 'list', 'url' => ['/city'],],
                            ['label' => 'Способы оплаты', 'icon' => 'list', 'url' => ['/payment'],],
                        ],
                    ],
                    ['label' => 'Отчеты', 'icon' => 'th', 'url' => '#',
                        'items' => [
                            ['label' => 'Прибыль агентов', 'icon' => 'list', 'url' => ['/report/agent'],],
                            ['label' => 'Прибыль системы', 'icon' => 'list', 'url' => ['/report/system'],],
                        ],'visible' => Yii::$app->user->can('admin'),
                    ],
                    ['label' => 'Настройки', 'icon' => 'gears', 'url' => '#',
                        'items' => [
                            ['label' => 'Пользователи', 'icon' => 'list', 'url' => ['/user'],],
                            ['label' => 'Уведомления', 'icon' => 'list', 'url' => ['/notice'],],
                            ['label' => 'Бэкенд', 'icon' => 'list', 'url' => ['/config/index', 'type' => Config::TYPE_BACKEND],],
                            ['label' => 'Фронтенд', 'icon' => 'list', 'url' => ['/config/index', 'type' => Config::TYPE_FRONTEND],],
                        ],'visible' => Yii::$app->user->can('admin'),
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
