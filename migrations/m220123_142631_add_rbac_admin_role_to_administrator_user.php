<?php

use yii\db\Migration;

/**
 * Class m220123_142631_add_rbac_admin_role_to_administrator_user
 */
class m220123_142631_add_rbac_admin_role_to_administrator_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $userRole = $auth->getRole('admin');
        $auth->assign($userRole, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAllAssignments();
    }
}
