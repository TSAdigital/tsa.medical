<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link text-center">
        <i class="fab fa-buffer"></i>
        <span class="brand-text font-weight-light"><b>TSA</b><sup><em><small>Medical</small></em></sup></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2 mb-5">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'НАВИГАЦИЯ', 'header' => true],
                    ['label' => 'Сотрудники', 'url' => ['workers/index'], 'icon' => 'id-card', 'active'=> $this->context->getUniqueId() == 'workers'],
                    ['label' => 'Медицинские карты', 'url' => ['medical-card/index'], 'icon' => 'notes-medical'],
                    ['label' => 'ЭДО', 'url' => ['documents/index'], 'icon' => 'file-invoice'],
                    ['label' => 'Оборудование', 'url' => ['equipments/index'], 'icon' => 'microscope'],
                    ['label' => 'Последняя активность', 'url' => ['action-history/index'], 'icon' => 'history'],
                    ['label' => 'СПРАВОЧНИКИ', 'header' => true],
                    [
                        'label' => 'Структура',
                        'icon' => 'building',
                        'items' => [
                            ['label' => 'Подразделения', 'url' => ['departments/index'], 'active'=> $this->context->getUniqueId() == 'departments', 'icon' => ''],
                            ['label' => 'Отделения', 'url' => ['divisions/index'], 'active'=> $this->context->getUniqueId() == 'divisions', 'icon' => ''],
                        ]
                    ],
                    [
                        'label' => 'Контрагенты',
                        'icon' => 'handshake',
                        'items' => [
                            ['label' => 'Юридические лица', 'url' => ['counterparties/index'], 'active'=> $this->context->getUniqueId() == 'counterparties', 'icon' => ''],
                            ['label' => 'Физические лица', 'url' => ['counterparties-fl/index'], 'active'=> $this->context->getUniqueId() == 'counterparties-fl', 'icon' => ''],
                        ]
                    ],
                    ['label' => 'Должности', 'url' => ['positions/index'], 'icon' => 'id-card-alt', 'active'=> $this->context->getUniqueId() == 'positions'],
                    ['label' => 'Справки', 'url' => ['references-type/index'], 'icon' => 'file', 'active'=> $this->context->getUniqueId() == 'references-type'],
                    ['label' => 'НАСТРОЙКИ', 'header' => true, 'visible' => Yii::$app->user->can('viewAdminOnly')],
                    ['label' => 'Пользователи', 'url' => ['users/index'], 'icon' => 'users', 'active'=> $this->context->getUniqueId() == 'users', 'visible' => Yii::$app->user->can('viewAdminOnly')],
                ],
            ]);
            ?>
        </nav>
        <div class="copyright small position-absolute fixed-bottom ml-2">
            <p class="mb-0 text-muted">Powered by <a class='text-decoration-none' href='https://www.yiiframework.com/' target='_blank' rel='noopener'>Yii Framework</a></p>
            <p class="mb-2 text-muted">Template <a class='text-decoration-none' href='https://adminlte.io/' target='_blank' rel='noopener'>AdminLTE</a></p>
        </div>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>