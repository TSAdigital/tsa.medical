<?php

use yii\db\Migration;

/**
 * Class m220123_134213_init_rbac
 */
class m220123_134213_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //Yii::$app->runAction('migrate', ['migrationPath' => '@yii/rbac/migrations', 'interactive' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220123_134213_init_rbac cannot be reverted.\n";
        return false;
    }
}
