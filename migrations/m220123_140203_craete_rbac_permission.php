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
        $positionCreate->description = 'Добавление должности';
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
        $positionHistory->description = 'История действий с должностью';
        $auth->add($positionHistory);

        $workerMenu = $auth->createPermission('workerMenu');
        $workerMenu->description = 'Отображать сотрудников в меню';
        $auth->add($workerMenu);

        $workerIndex = $auth->createPermission('workerIndex');
        $workerIndex->description = 'Просмотр списка сотрудников';
        $auth->add($workerIndex);

        $workerCreate = $auth->createPermission('workerCreate');
        $workerCreate->description = 'Добавление сотрудника';
        $auth->add($workerCreate);

        $workerView = $auth->createPermission('workerView');
        $workerView->description = 'Просмотр сотрудника';
        $auth->add($workerView);

        $workerUpdate = $auth->createPermission('workerUpdate');
        $workerUpdate->description = 'Редактирование сотрудника';
        $auth->add($workerUpdate);

        $workerActive = $auth->createPermission('workerActive');
        $workerActive->description = 'Активация сотрудника';
        $auth->add($workerActive);

        $workerBlocked = $auth->createPermission('workerBlocked');
        $workerBlocked->description = 'Аннулирование сотрудника';
        $auth->add($workerBlocked);

        $workerHistory = $auth->createPermission('workerHistory');
        $workerHistory->description = 'Историй действий с сотрудником';
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

        $historyMenu = $auth->createPermission('historyMenu');
        $historyMenu->description = 'Отображать последнюю активность в меню';
        $auth->add($historyMenu);

        $historyIndex = $auth->createPermission('historyIndex');
        $historyIndex->description = 'Просмотр последней активности';
        $auth->add($historyIndex);

        $departmentMenu = $auth->createPermission('departmentMenu');
        $departmentMenu->description = 'Отображать подразделения в меню';
        $auth->add($departmentMenu);

        $departmentIndex = $auth->createPermission('departmentIndex');
        $departmentIndex->description = 'Просмотр списка подразделений';
        $auth->add($departmentIndex);

        $departmentCreate = $auth->createPermission('departmentCreate');
        $departmentCreate->description = 'Добавление подразделения';
        $auth->add($departmentCreate);

        $departmentView = $auth->createPermission('departmentView');
        $departmentView->description = 'Просмотр подразделения';
        $auth->add($departmentView);

        $departmentUpdate = $auth->createPermission('departmentUpdate');
        $departmentUpdate->description = 'Редактирование подразделения';
        $auth->add($departmentUpdate);

        $departmentActive = $auth->createPermission('departmentActive');
        $departmentActive->description = 'Активация подразделения';
        $auth->add($departmentActive);

        $departmentBlocked = $auth->createPermission('departmentBlocked');
        $departmentBlocked->description = 'Аннулирование подразделения';
        $auth->add($departmentBlocked);

        $departmentHistory = $auth->createPermission('departmentHistory');
        $departmentHistory->description = 'Иторий действий с подразделением';
        $auth->add($departmentHistory);

        $divisionMenu = $auth->createPermission('divisionMenu');
        $divisionMenu->description = 'Отображать отделения в меню';
        $auth->add($divisionMenu);

        $divisionIndex = $auth->createPermission('divisionIndex');
        $divisionIndex->description = 'Просмотр списка отделений';
        $auth->add($divisionIndex);

        $divisionCreate = $auth->createPermission('divisionCreate');
        $divisionCreate->description = 'Добавление отделения';
        $auth->add($divisionCreate);

        $divisionView = $auth->createPermission('divisionView');
        $divisionView->description = 'Просмотр отделения';
        $auth->add($divisionView);

        $divisionUpdate = $auth->createPermission('divisionUpdate');
        $divisionUpdate->description = 'Редактирование отделения';
        $auth->add($divisionUpdate);

        $divisionActive = $auth->createPermission('divisionActive');
        $divisionActive->description = 'Активация отделения';
        $auth->add($divisionActive);

        $divisionBlocked = $auth->createPermission('divisionBlocked');
        $divisionBlocked->description = 'Аннулирование отделения';
        $auth->add($divisionBlocked);

        $divisionHistory = $auth->createPermission('divisionHistory');
        $divisionHistory->description = 'Историй действий с отделением';
        $auth->add($divisionHistory);

        $specializationMenu = $auth->createPermission('specializationMenu');
        $specializationMenu->description = 'Отображать специальности в меню';
        $auth->add($specializationMenu);

        $specializationIndex = $auth->createPermission('specializationIndex');
        $specializationIndex->description = 'Просмотр списка специальностей';
        $auth->add($specializationIndex);

        $specializationCreate = $auth->createPermission('specializationCreate');
        $specializationCreate->description = 'Добавление специальности';
        $auth->add($specializationCreate);

        $specializationView = $auth->createPermission('specializationView');
        $specializationView->description = 'Просмотр специальности';
        $auth->add($specializationView);

        $specializationUpdate = $auth->createPermission('specializationUpdate');
        $specializationUpdate->description = 'Редактирование специальности';
        $auth->add($specializationUpdate);

        $specializationActive = $auth->createPermission('specializationActive');
        $specializationActive->description = 'Активация специальности';
        $auth->add($specializationActive);

        $specializationBlocked = $auth->createPermission('specializationBlocked');
        $specializationBlocked->description = 'Аннулирование специальности';
        $auth->add($specializationBlocked);

        $specializationHistory = $auth->createPermission('specializationHistory');
        $specializationHistory->description = 'Историй действий с специальностью';
        $auth->add($specializationHistory);

        $referenceTypeMenu = $auth->createPermission('referenceTypeMenu');
        $referenceTypeMenu->description = 'Отображать вид справки в меню';
        $auth->add($referenceTypeMenu);

        $referenceTypeIndex = $auth->createPermission('referenceTypeIndex');
        $referenceTypeIndex->description = 'Просмотр списка видов справок';
        $auth->add($referenceTypeIndex);

        $referenceTypeCreate = $auth->createPermission('referenceTypeCreate');
        $referenceTypeCreate->description = 'Добавление вида справки';
        $auth->add($referenceTypeCreate);

        $referenceTypeView = $auth->createPermission('referenceTypeView');
        $referenceTypeView->description = 'Просмотр вида справки';
        $auth->add($referenceTypeView);

        $referenceTypeUpdate = $auth->createPermission('referenceTypeUpdate');
        $referenceTypeUpdate->description = 'Редактирование вида справки';
        $auth->add($referenceTypeUpdate);

        $referenceTypeActive = $auth->createPermission('referenceTypeActive');
        $referenceTypeActive->description = 'Активация вида справки';
        $auth->add($referenceTypeActive);

        $referenceTypeBlocked = $auth->createPermission('referenceTypeBlocked');
        $referenceTypeBlocked->description = 'Аннулирование вида справки';
        $auth->add($referenceTypeBlocked);

        $referenceTypeHistory = $auth->createPermission('referenceTypeHistory');
        $referenceTypeHistory->description = 'История действий с видом справки';
        $auth->add($referenceTypeHistory);

        $vaccineMenu = $auth->createPermission('vaccineMenu');
        $vaccineMenu->description = 'Отображать вакцины в меню';
        $auth->add($vaccineMenu);

        $vaccineIndex = $auth->createPermission('vaccineIndex');
        $vaccineIndex->description = 'Просмотр списка вакцин';
        $auth->add($vaccineIndex);

        $vaccineCreate = $auth->createPermission('vaccineCreate');
        $vaccineCreate->description = 'Добавление вакцины';
        $auth->add($vaccineCreate);

        $vaccineView = $auth->createPermission('vaccineView');
        $vaccineView->description = 'Просмотр вакцины';
        $auth->add($vaccineView);

        $vaccineUpdate = $auth->createPermission('vaccineUpdate');
        $vaccineUpdate->description = 'Редактирование вакцины';
        $auth->add($vaccineUpdate);

        $vaccineActive = $auth->createPermission('vaccineActive');
        $vaccineActive->description = 'Активация вакцины';
        $auth->add($vaccineActive);

        $vaccineBlocked = $auth->createPermission('vaccineBlocked');
        $vaccineBlocked->description = 'Аннулирование вакцины';
        $auth->add($vaccineBlocked);

        $vaccineHistory = $auth->createPermission('vaccineHistory');
        $vaccineHistory->description = 'История действий с вакциной';
        $auth->add($vaccineHistory);

        $counterpartyMenu = $auth->createPermission('counterpartyMenu');
        $counterpartyMenu->description = 'Отображать контрагенты ЮЛ в меню';
        $auth->add($counterpartyMenu);

        $counterpartyIndex = $auth->createPermission('counterpartyIndex');
        $counterpartyIndex->description = 'Просмотр списка контрагентов ЮЛ';
        $auth->add($counterpartyIndex);

        $counterpartyCreate = $auth->createPermission('counterpartyCreate');
        $counterpartyCreate->description = 'Добавление контрагента ЮЛ';
        $auth->add($counterpartyCreate);

        $counterpartyView = $auth->createPermission('counterpartyView');
        $counterpartyView->description = 'Просмотр контрагента ЮЛ';
        $auth->add($counterpartyView);

        $counterpartyUpdate = $auth->createPermission('counterpartyUpdate');
        $counterpartyUpdate->description = 'Редактирование контрагента ЮЛ';
        $auth->add($counterpartyUpdate);

        $counterpartyActive = $auth->createPermission('counterpartyActive');
        $counterpartyActive->description = 'Активация контрагента ЮЛ';
        $auth->add($counterpartyActive);

        $counterpartyBlocked = $auth->createPermission('counterpartyBlocked');
        $counterpartyBlocked->description = 'Аннулирование контрагента ЮЛ';
        $auth->add($counterpartyBlocked);

        $counterpartyHistory = $auth->createPermission('counterpartyHistory');
        $counterpartyHistory->description = 'История действий с контрагентом ЮЛ';
        $auth->add($counterpartyHistory);

        $counterpartyAddressMenu = $auth->createPermission('counterpartyAddressMenu');
        $counterpartyAddressMenu->description = 'Отображать вкладку адреса у контрагента ЮЛ';
        $auth->add($counterpartyAddressMenu);

        $counterpartyAddressIndex = $auth->createPermission('counterpartyAddressIndex');
        $counterpartyAddressIndex->description = 'Просмотр списка адресов у контрагента ЮЛ';
        $auth->add($counterpartyAddressIndex);

        $counterpartyAddressCreate = $auth->createPermission('counterpartyAddressCreate');
        $counterpartyAddressCreate->description = 'Добавить адрес контрагенту ЮЛ';
        $auth->add($counterpartyAddressCreate);

        $counterpartyAddressView = $auth->createPermission('counterpartyAddressView');
        $counterpartyAddressView->description = 'Просмотр адреса у контрагента ЮЛ';
        $auth->add($counterpartyAddressView);

        $counterpartyAddressUpdate = $auth->createPermission('counterpartyAddressUpdate');
        $counterpartyAddressUpdate->description = 'Редактирование адреса у контрагента ЮЛ';
        $auth->add($counterpartyAddressUpdate);

        $counterpartyAddressActive = $auth->createPermission('counterpartyAddressActive');
        $counterpartyAddressActive->description = 'Активация адреса у контрагента ЮЛ';
        $auth->add($counterpartyAddressActive);

        $counterpartyAddressBlocked = $auth->createPermission('counterpartyAddressBlocked');
        $counterpartyAddressBlocked->description = 'Аннулирование адреса у контрагента ЮЛ';
        $auth->add($counterpartyAddressBlocked);

        $counterpartyContactMenu = $auth->createPermission('counterpartyContactMenu');
        $counterpartyContactMenu->description = 'Отображать вкладку контакты у контрагента ЮЛ';
        $auth->add($counterpartyContactMenu);

        $counterpartyContactIndex = $auth->createPermission('counterpartyContactIndex');
        $counterpartyContactIndex->description = 'Просмотр списка контактов у контрагента ЮЛ';
        $auth->add($counterpartyContactIndex);

        $counterpartyContactCreate = $auth->createPermission('counterpartyContactCreate');
        $counterpartyContactCreate->description = 'Добавить контакт контрагенту ЮЛ';
        $auth->add($counterpartyContactCreate);

        $counterpartyContactView = $auth->createPermission('counterpartyContactView');
        $counterpartyContactView->description = 'Просмотр контакта у контрагента ЮЛ';
        $auth->add($counterpartyContactView);

        $counterpartyContactUpdate = $auth->createPermission('counterpartyContactUpdate');
        $counterpartyContactUpdate->description = 'Редактирование контакта у контрагента ЮЛ';
        $auth->add($counterpartyContactUpdate);

        $counterpartyContactActive = $auth->createPermission('counterpartyContactActive');
        $counterpartyContactActive->description = 'Активация контакта у контрагента ЮЛ';
        $auth->add($counterpartyContactActive);

        $counterpartyContactBlocked = $auth->createPermission('counterpartyContactBlocked');
        $counterpartyContactBlocked->description = 'Аннулирование контакта у контрагента ЮЛ';
        $auth->add($counterpartyContactBlocked);

        $counterpartyFlMenu = $auth->createPermission('counterpartyFlMenu');
        $counterpartyFlMenu->description = 'Отображать контрагенты ФЛ в меню';
        $auth->add($counterpartyFlMenu);

        $counterpartyFlIndex = $auth->createPermission('counterpartyFlIndex');
        $counterpartyFlIndex->description = 'Просмотр списка контрагентов ФЛ';
        $auth->add($counterpartyFlIndex);

        $counterpartyFlCreate = $auth->createPermission('counterpartyFlCreate');
        $counterpartyFlCreate->description = 'Добавление контрагента ФЛ';
        $auth->add($counterpartyFlCreate);

        $counterpartyFlView = $auth->createPermission('counterpartyFlView');
        $counterpartyFlView->description = 'Просмотр контрагента ФЛ';
        $auth->add($counterpartyFlView);

        $counterpartyFlUpdate = $auth->createPermission('counterpartyFlUpdate');
        $counterpartyFlUpdate->description = 'Редактирование контрагента ФЛ';
        $auth->add($counterpartyFlUpdate);

        $counterpartyFlActive = $auth->createPermission('counterpartyFlActive');
        $counterpartyFlActive->description = 'Активация контрагента ФЛ';
        $auth->add($counterpartyFlActive);

        $counterpartyFlBlocked = $auth->createPermission('counterpartyFlBlocked');
        $counterpartyFlBlocked->description = 'Аннулирование контрагента ФЛ';
        $auth->add($counterpartyFlBlocked);

        $counterpartyFlHistory = $auth->createPermission('counterpartyFlHistory');
        $counterpartyFlHistory->description = 'История действий с контрагентом ФЛ';
        $auth->add($counterpartyFlHistory);

        $counterpartyFlPassportMenu = $auth->createPermission('counterpartyFlPassportMenu');
        $counterpartyFlPassportMenu->description = 'Отображать вкладку паспорт у контрагента ФЛ';
        $auth->add($counterpartyFlPassportMenu);

        $counterpartyFlPassportIndex = $auth->createPermission('counterpartyFlPassportIndex');
        $counterpartyFlPassportIndex->description = 'Просмотр списка паспортов у контрагента ФЛ';
        $auth->add($counterpartyFlPassportIndex);

        $counterpartyFlPassportCreate = $auth->createPermission('counterpartyFlPassportCreate');
        $counterpartyFlPassportCreate->description = 'Добавить паспорт контрагенту ФЛ';
        $auth->add($counterpartyFlPassportCreate);

        $counterpartyFlPassportView = $auth->createPermission('counterpartyFlPassportView');
        $counterpartyFlPassportView->description = 'Просмотр паспорта у контрагента ФЛ';
        $auth->add($counterpartyFlPassportView);

        $counterpartyFlPassportUpdate = $auth->createPermission('counterpartyFlPassportUpdate');
        $counterpartyFlPassportUpdate->description = 'Редактирование паспорта у контрагента ФЛ';
        $auth->add($counterpartyFlPassportUpdate);

        $counterpartyFlPassportActive = $auth->createPermission('counterpartyFlPassportActive');
        $counterpartyFlPassportActive->description = 'Активация паспорта у контрагента ФЛ';
        $auth->add($counterpartyFlPassportActive);

        $counterpartyFlPassportBlocked = $auth->createPermission('counterpartyFlPassportBlocked');
        $counterpartyFlPassportBlocked->description = 'Аннулирование паспорта у контрагента ФЛ';
        $auth->add($counterpartyFlPassportBlocked);

        $counterpartyFlAddressMenu = $auth->createPermission('counterpartyFlAddressMenu');
        $counterpartyFlAddressMenu->description = 'Отображать вкладку адреса у контрагента ФЛ';
        $auth->add($counterpartyFlAddressMenu);

        $counterpartyFlAddressIndex = $auth->createPermission('counterpartyFlAddressIndex');
        $counterpartyFlAddressIndex->description = 'Просмотр списка адресов у контрагента ФЛ';
        $auth->add($counterpartyFlAddressIndex);

        $counterpartyFlAddressCreate = $auth->createPermission('counterpartyFlAddressCreate');
        $counterpartyFlAddressCreate->description = 'Добавить адрес контрагенту ФЛ';
        $auth->add($counterpartyFlAddressCreate);

        $counterpartyFlAddressView = $auth->createPermission('counterpartyFlAddressView');
        $counterpartyFlAddressView->description = 'Просмотр адреса у контрагента ФЛ';
        $auth->add($counterpartyFlAddressView);

        $counterpartyFlAddressUpdate = $auth->createPermission('counterpartyFlAddressUpdate');
        $counterpartyFlAddressUpdate->description = 'Редактирование адреса у контрагента ФЛ';
        $auth->add($counterpartyFlAddressUpdate);

        $counterpartyFlAddressActive = $auth->createPermission('counterpartyFlAddressActive');
        $counterpartyFlAddressActive->description = 'Активация адреса у контрагента ФЛ';
        $auth->add($counterpartyFlAddressActive);

        $counterpartyFlAddressBlocked = $auth->createPermission('counterpartyFlAddressBlocked');
        $counterpartyFlAddressBlocked->description = 'Аннулирование адреса у контрагента ФЛ';
        $auth->add($counterpartyFlAddressBlocked);
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
