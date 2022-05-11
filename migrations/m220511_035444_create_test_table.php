<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%test}}`.
 */
class m220511_035444_create_test_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $workMenu = $auth->createPermission('workMenu');
        $workMenu->description = 'Отображать деятельность в меню у сотрудника';
        $auth->add($workMenu);

        $workIndex = $auth->createPermission('workIndex');
        $workIndex->description = 'Просмотр списка деятельностей у сотрудника';
        $auth->add($workIndex);

        $workCreate = $auth->createPermission('workCreate');
        $workCreate->description = 'Добавить деятельность сотруднику';
        $auth->add($workCreate);

        $workView = $auth->createPermission('workView');
        $workView->description = 'Просмотр деятельност у сотрудника';
        $auth->add($workView);

        $workUpdate = $auth->createPermission('workUpdate');
        $workUpdate->description = 'Редактирование деятельности у сотрудника';
        $auth->add($workUpdate);

        $workActive = $auth->createPermission('workActive');
        $workActive->description = 'Активация деятельности у сотрудника';
        $auth->add($workActive);

        $workBlocked = $auth->createPermission('workBlocked');
        $workBlocked->description = 'Аннулирование деятельности у сотрудника';
        $auth->add($workBlocked);
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
