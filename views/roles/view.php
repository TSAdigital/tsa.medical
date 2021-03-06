<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */
/* @var $roleName app\models\AuthItem */
/* @var $permissions app\models\AuthItemChild */

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
    'update' => $model->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-app']) : false,
    'block' => $model->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked', 'id' => $model->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Аннулировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $model->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active', 'id' => $model->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Активировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'history' => Html::a('<i class="fas fa-history text-info"></i>История', ['history', 'id' => $model->id], ['class' => 'btn btn-app']),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['index'], ['class' => 'btn btn-app'])
];
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills" id="myTab">
                        <li class="nav-item"><a class="nav-link active" href="#base" data-toggle="tab">Основное</a></li>
                        <li class="nav-item"><a class="nav-link" href="#permissions" data-toggle="tab">Разрешения</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body pb-1">
                    <div class="tab-content">
                        <div class="active tab-pane" id="base">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'description',
                                        'captionOptions' => ['width' => '200px'],
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'value' => $model->getStatusName(),
                                    ],
                                    'created_at:datetime',
                                    'updated_at:datetime',
                                ],
                            ]) ?>
                        </div>
                        <div class="tab-pane" id="permissions">
                            <?php $form = ActiveForm::begin(); ?>
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left p-0 m-0" type="button"
                                                    data-toggle="collapse" data-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                НАВИГАЦИЯ
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                         data-parent="#accordionExample">
                                        <div class="card-body m-1 p-1">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Раздел</th>
                                                        <th scope="col" class="text-center">Меню</th>
                                                        <th scope="col" class="text-center">Список</th>
                                                        <th scope="col" class="text-center">Добавить</th>
                                                        <th scope="col" class="text-center">Просмотр</th>
                                                        <th scope="col" class="text-center">Редактировать</th>
                                                        <th scope="col" class="text-center">Активировать</th>
                                                        <th scope="col" class="text-center">Аннулировать</th>
                                                        <th scope="col" class="text-center">История</th>
                                                        <th scope="col" class="text-center">Удалить</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row" class="align-middle">Сотрудники</th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workerMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workerIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workerCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workerView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workerUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workerActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workerBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerHistory', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workerHistory', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle text-right ">
                                                            <em><small>Деятельность</small></em></th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('workBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle text-right ">
                                                            <em><small>Сертификаты</small></em></th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('certificateMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('certificateIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('certificateCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('certificateView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('certificateUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('certificateActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('certificateBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle text-right "><em><small>Справки</small></em>
                                                        </th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle text-right ">
                                                            <em><small>Вакцинация</small></em></th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccinationMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccinationIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccinationCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccinationView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccinationUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccinationActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccinationBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle text-right ">
                                                            <em><small>Файлы</small></em></th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('fileMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('fileIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('fileCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('fileView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('fileUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('fileActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('fileBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileDelete', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('fileDelete', $roleName)])->label('') ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="align-middle">Последняя активность</th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'historyMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('historyMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'historyIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('historyIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="headingTwo">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left collapsed p-0 m-0" type="button"
                                                    data-toggle="collapse" data-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                СПРАВОЧНИКИ
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                         data-parent="#accordionExample">
                                        <div class="card-body m-1 p-1">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered mb-0">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Раздел</th>
                                                        <th scope="col" class="text-center">Меню</th>
                                                        <th scope="col" class="text-center">Список</th>
                                                        <th scope="col" class="text-center">Добавить</th>
                                                        <th scope="col" class="text-center">Просмотр</th>
                                                        <th scope="col" class="text-center">Редактировать</th>
                                                        <th scope="col" class="text-center">Активировать</th>
                                                        <th scope="col" class="text-center">Аннулировать</th>
                                                        <th scope="col" class="text-center">История</th>
                                                        <th scope="col" class="text-center">Удалить</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th scope="row" class="align-middle">Подразделения</th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'departmentMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('departmentMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'departmentIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('departmentIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'departmentCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('departmentCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'departmentView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('departmentView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'departmentUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('departmentUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'departmentActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('departmentActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'departmentBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('departmentBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'departmentHistory', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('departmentHistory', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="align-middle">Отделения</th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'divisionMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('divisionMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'divisionIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('divisionIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'divisionCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('divisionCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'divisionView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('divisionView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'divisionUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('divisionUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'divisionActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('divisionActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'divisionBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('divisionBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'divisionHistory', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('divisionHistory', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="align-middle">Контрагенты ЮЛ</th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyHistory', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyHistory', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle text-right ">
                                                            <em><small>Адреса</small></em></th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyAddressMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyAddressMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyAddressIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyAddressIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyAddressCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyAddressCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyAddressView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyAddressView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyAddressUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyAddressUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyAddressActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyAddressActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyAddressBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyAddressBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle text-right "><em><small>Контакты</small></em>
                                                        </th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyContactMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyContactMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyContactIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyContactIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyContactCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyContactCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyContactView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyContactView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyContactUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyContactUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyContactActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyContactActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyContactBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyContactBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="align-middle">Контрагенты ФЛ</th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlHistory', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlHistory', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle text-right "><em><small>Паспорт</small></em>
                                                        </th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlPassportMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlPassportMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlPassportIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlPassportIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlPassportCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlPassportCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlPassportView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlPassportView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlPassportUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlPassportUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlPassportActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlPassportActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlPassportBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlPassportBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="align-middle text-right ">
                                                            <em><small>Адреса</small></em></th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlAddressMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlAddressMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlAddressIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlAddressIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlAddressCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlAddressCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlAddressView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlAddressView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlAddressUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlAddressUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlAddressActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlAddressActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'counterpartyFlAddressBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('counterpartyFlAddressBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="align-middle">Должности</th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('positionMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('positionIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('positionCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('positionView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('positionUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('positionActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('positionBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionHistory', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('positionHistory', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="align-middle">Специальности</th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'specializationMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('specializationMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'specializationIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('specializationIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'specializationCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('specializationCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'specializationView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('specializationView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'specializationUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('specializationUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'specializationActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('specializationActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'specializationBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('specializationBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'specializationHistory', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('specializationHistory', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="align-middle">Справки</th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceTypeMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceTypeMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceTypeIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceTypeIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceTypeCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceTypeCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceTypeView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceTypeView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceTypeUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceTypeUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceTypeActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceTypeActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceTypeBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceTypeBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceTypeHistory', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('referenceTypeHistory', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row" class="align-middle">Вакцины</th>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccineMenu', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccineMenu', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccineIndex', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccineIndex', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccineCreate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccineCreate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccineView', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccineView', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccineUpdate', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccineUpdate', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccineActive', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccineActive', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccineBlocked', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccineBlocked', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccineHistory', ['options' => ['tag' => false]])->checkbox(['checked' => $permissions->checked('vaccineHistory', $roleName)])->label('') ?></td>
                                                        <td class="text-center align-middle"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?= Html::a('<i class="far fa-save text-success"></i>Сохранить', ['permissions', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block', 'data' => [
                                        'method' => 'post',
                                    ],
                                    ]) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>