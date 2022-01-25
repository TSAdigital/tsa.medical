<?php

use yii\db\Migration;

/**
 * Class m220123_135006_create_rbac_role
 */
class m220123_135006_create_rbac_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole('admin');
        $role->description = 'Администратор';
        $auth->add($role);

        $role = $auth->createRole('user');
        $role->description = 'Пользователь';
        $auth->add($role);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAllRoles();
    }
}
