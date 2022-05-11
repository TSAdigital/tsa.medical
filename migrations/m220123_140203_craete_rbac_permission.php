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

        $positionMenu = $auth->createPermission('positionMenu');
        $positionMenu->description = 'Отображать должности в меню';
        $auth->add($positionMenu);

        $positionIndex = $auth->createPermission('positionIndex');
        $positionIndex->description = 'Просмотр списка должностей';
        $auth->add($positionIndex);

        $positionCreate = $auth->createPermission('positionCreate');
        $positionCreate->description = 'Просмотр должности';
        $auth->add($positionCreate);

        $positionView = $auth->createPermission('positionView');
        $positionView->description = 'Просмотр должности';
        $auth->add($positionView);

        $positionUpdate = $auth->createPermission('positionUpdate');
        $positionUpdate->description = 'Редактирование должности';
        $auth->add($positionUpdate);

        $positionActive = $auth->createPermission('positionActive');
        $positionActive->description = 'Активация должности';
        $auth->add($positionActive);

        $positionBlocked = $auth->createPermission('positionBlocked');
        $positionBlocked->description = 'Аннулирование должности';
        $auth->add($positionBlocked);

        $positionHistory = $auth->createPermission('positionHistory');
        $positionHistory->description = 'Аннулирование должности';
        $auth->add($positionHistory);

        $workerMenu = $auth->createPermission('workerMenu');
        $workerMenu->description = 'Отображать должности в меню';
        $auth->add($workerMenu);

        $workerIndex = $auth->createPermission('workerIndex');
        $workerIndex->description = 'Просмотр списка должностей';
        $auth->add($workerIndex);

        $workerCreate = $auth->createPermission('workerCreate');
        $workerCreate->description = 'Просмотр должности';
        $auth->add($workerCreate);

        $workerView = $auth->createPermission('workerView');
        $workerView->description = 'Просмотр должности';
        $auth->add($workerView);

        $workerUpdate = $auth->createPermission('workerUpdate');
        $workerUpdate->description = 'Редактирование должности';
        $auth->add($workerUpdate);

        $workerActive = $auth->createPermission('workerActive');
        $workerActive->description = 'Активация должности';
        $auth->add($workerActive);

        $workerBlocked = $auth->createPermission('workerBlocked');
        $workerBlocked->description = 'Аннулирование должности';
        $auth->add($workerBlocked);

        $workerHistory = $auth->createPermission('workerHistory');
        $workerHistory->description = 'Аннулирование должности';
        $auth->add($workerHistory);

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
