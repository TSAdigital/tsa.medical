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
        $positionIndex->description = 'Просмотр списока должностей';
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
        $workerIndex->description = 'Просмотр списока должностей';
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
