<?php
use hail812\adminlte\widgets\Menu;
?>

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
            <?= Menu::widget([
                'items' => [
                    ['label' => 'НАВИГАЦИЯ', 'header' => true],
                    ['label' => 'Сотрудники', 'url' => ['workers/index'], 'icon' => 'user-md', 'active'=> $this->context->getUniqueId() == 'workers', 'visible' => Yii::$app->user->can('workerMenu') or Yii::$app->user->can('admin')],
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
                    ['label' => 'Должности', 'url' => ['positions/index'], 'icon' => 'id-card', 'active'=> $this->context->getUniqueId() == 'positions', 'visible' => Yii::$app->user->can('positionMenu') or Yii::$app->user->can('admin')],
                    ['label' => 'Специальности', 'url' => ['specializations/index'], 'icon' => 'id-card-alt', 'active'=> $this->context->getUniqueId() == 'specializations'],
                    ['label' => 'Справки', 'url' => ['references-type/index'], 'icon' => 'file', 'active'=> $this->context->getUniqueId() == 'references-type'],
                    ['label' => 'Вакцины', 'url' => ['vaccines/index'], 'icon' => 'syringe', 'active'=> $this->context->getUniqueId() == 'vaccines'],
                    ['label' => 'НАСТРОЙКИ', 'header' => true, 'visible' => Yii::$app->user->can('admin')],
                    ['label' => 'Пользователи', 'url' => ['users/index'], 'icon' => 'users', 'active'=> $this->context->getUniqueId() == 'users', 'visible' => Yii::$app->user->can('admin')],
                    ['label' => 'Роли', 'url' => ['roles/index'], 'icon' => 'user-tag', 'active'=> $this->context->getUniqueId() == 'roles', 'visible' => Yii::$app->user->can('admin')],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>