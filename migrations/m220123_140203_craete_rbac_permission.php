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
        $workMenu->description = 'Отображать вкладку деятельность у сотрудника';
        $auth->add($workMenu);

        $workIndex = $auth->createPermission('workIndex');
        $workIndex->description = 'Просмотр списка деятельностей у сотрудника';
        $auth->add($workIndex);

        $workCreate = $auth->createPermission('workCreate');
        $workCreate->description = 'Добавить деятельность сотруднику';
        $auth->add($workCreate);

        $workView = $auth->createPermission('workView');
        $workView->description = 'Просмотр деятельности у сотрудника';
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

        $certificateMenu = $auth->createPermission('certificateMenu');
        $certificateMenu->description = 'Отображать вкладку сертификаты у сотрудника';
        $auth->add($certificateMenu);

        $certificateIndex = $auth->createPermission('certificateIndex');
        $certificateIndex->description = 'Просмотр списка сертификатов у сотрудника';
        $auth->add($certificateIndex);

        $certificateCreate = $auth->createPermission('certificateCreate');
        $certificateCreate->description = 'Добавить сертификат сотруднику';
        $auth->add($certificateCreate);

        $certificateView = $auth->createPermission('certificateView');
        $certificateView->description = 'Просмотр сертификата у сотрудника';
        $auth->add($certificateView);

        $certificateUpdate = $auth->createPermission('certificateUpdate');
        $certificateUpdate->description = 'Редактирование сертификата у сотрудника';
        $auth->add($certificateUpdate);

        $certificateActive = $auth->createPermission('certificateActive');
        $certificateActive->description = 'Активация сертификата у сотрудника';
        $auth->add($certificateActive);

        $certificateBlocked = $auth->createPermission('certificateBlocked');
        $certificateBlocked->description = 'Аннулирование сертификата у сотрудника';
        $auth->add($certificateBlocked);

        $referenceMenu = $auth->createPermission('referenceMenu');
        $referenceMenu->description = 'Отображать вкладку справки у сотрудника';
        $auth->add($referenceMenu);

        $referenceIndex = $auth->createPermission('referenceIndex');
        $referenceIndex->description = 'Просмотр списка справок у сотрудника';
        $auth->add($referenceIndex);

        $referenceCreate = $auth->createPermission('referenceCreate');
        $referenceCreate->description = 'Добавить справку сотруднику';
        $auth->add($referenceCreate);

        $referenceView = $auth->createPermission('referenceView');
        $referenceView->description = 'Просмотр справки у сотрудника';
        $auth->add($referenceView);

        $referenceUpdate = $auth->createPermission('referenceUpdate');
        $referenceUpdate->description = 'Редактирование справки у сотрудника';
        $auth->add($referenceUpdate);

        $referenceActive = $auth->createPermission('referenceActive');
        $referenceActive->description = 'Активация справки у сотрудника';
        $auth->add($referenceActive);

        $referenceBlocked = $auth->createPermission('referenceBlocked');
        $referenceBlocked->description = 'Аннулирование справки у сотрудника';
        $auth->add($referenceBlocked);

        $vaccinationMenu = $auth->createPermission('vaccinationMenu');
        $vaccinationMenu->description = 'Отображать вкладку вакцинация у сотрудника';
        $auth->add($vaccinationMenu);

        $vaccinationIndex = $auth->createPermission('vaccinationIndex');
        $vaccinationIndex->description = 'Просмотр списка вакцинаций у сотрудника';
        $auth->add($vaccinationIndex);

        $vaccinationCreate = $auth->createPermission('vaccinationCreate');
        $vaccinationCreate->description = 'Добавить вакцинацию сотруднику';
        $auth->add($vaccinationCreate);

        $vaccinationView = $auth->createPermission('vaccinationView');
        $vaccinationView->description = 'Просмотр вакцинации у сотрудника';
        $auth->add($vaccinationView);

        $vaccinationUpdate = $auth->createPermission('vaccinationUpdate');
        $vaccinationUpdate->description = 'Редактирование вакцинации у сотрудника';
        $auth->add($vaccinationUpdate);

        $vaccinationActive = $auth->createPermission('vaccinationActive');
        $vaccinationActive->description = 'Активация вакцинации у сотрудника';
        $auth->add($vaccinationActive);

        $vaccinationBlocked = $auth->createPermission('vaccinationBlocked');
        $vaccinationBlocked->description = 'Аннулирование вакцинации у сотрудника';
        $auth->add($vaccinationBlocked);

        $fileMenu = $auth->createPermission('fileMenu');
        $fileMenu->description = 'Отображать вкладку файлы у сотрудника';
        $auth->add($fileMenu);

        $fileIndex = $auth->createPermission('fileIndex');
        $fileIndex->description = 'Просмотр списка файлов у сотрудника';
        $auth->add($fileIndex);

        $fileCreate = $auth->createPermission('fileCreate');
        $fileCreate->description = 'Добавить файл сотруднику';
        $auth->add($fileCreate);

        $fileView = $auth->createPermission('fileView');
        $fileView->description = 'Просмотр файла у сотрудника';
        $auth->add($fileView);

        $fileUpdate = $auth->createPermission('fileUpdate');
        $fileUpdate->description = 'Редактирование файла у сотрудника';
        $auth->add($fileUpdate);

        $fileActive = $auth->createPermission('fileActive');
        $fileActive->description = 'Активация файла у сотрудника';
        $auth->add($fileActive);

        $fileBlocked = $auth->createPermission('fileBlocked');
        $fileBlocked->description = 'Аннулирование файла у сотрудника';
        $auth->add($fileBlocked);

        $fileDelete = $auth->createPermission('fileDelete');
        $fileDelete->description = 'Удаление файла у сотрудника';
        $auth->add($fileDelete);
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
