<?php

use yii\db\Migration;

/**
 * Class m220123_142022_craete_rbac_link_roles_and_permissions
 */
class m220123_142022_craete_rbac_link_roles_and_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $roleAdmin = $auth->getRole('admin');
        $roleUser = $auth->getRole('user');
        $permission = $auth->getPermission('viewAdminOnly');
        $auth->addChild($roleAdmin, $permission);
        $auth->addChild($roleAdmin, $roleUser);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $roleAdmin = $auth->getRole('admin');
        $roleUser = $auth->getRole('user');
        $permission = $auth->getPermission('viewAdminOnly');
        $auth->removeChild($roleAdmin, $permission);
        $auth->removeChild($roleAdmin, $roleUser);
    }
}
