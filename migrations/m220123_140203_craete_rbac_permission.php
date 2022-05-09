<?php

use yii\db\Migration;

/**
 * Class m220123_140203_craete_rbac_permission
 */
class m220123_140203_craete_rbac_permission extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $permission = $auth->createPermission('viewAdminOnly');
        $permission->description = 'Видно только администратору';
        $auth->add($permission);

        $viewPositionMenu = $auth->createPermission('viewPositionMenu');
        $viewPositionMenu->description = 'Отображать должности в меню';
        $auth->add($viewPositionMenu);

        $viewPositionIndex = $auth->createPermission('viewPositionIndex');
        $viewPositionIndex->description = 'Просмотр списока должностей';
        $auth->add($viewPositionIndex);

        $viewPositionView = $auth->createPermission('viewPositionView');
        $viewPositionView->description = 'Просмотр должности';
        $auth->add($viewPositionView);

        $viewPositionUpdate = $auth->createPermission('viewPositionUpdate');
        $viewPositionUpdate->description = 'Редактирование должности';
        $auth->add($viewPositionUpdate);

        $viewPositionActive = $auth->createPermission('viewPositionActive');
        $viewPositionActive->description = 'Активация должности';
        $auth->add($viewPositionActive);

        $viewPositionBlocked = $auth->createPermission('viewPositionBlocked');
        $viewPositionBlocked->description = 'Аннулирование должности';
        $auth->add($viewPositionBlocked);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAllPermissions();
    }
}
