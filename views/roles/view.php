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
                        <li class="nav-item"><a class="nav-link" href="#permissions" data-toggle="tab">Разрешения</a></li>
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
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">Раздел</th>
                                        <th scope="col" class="text-center">Меню</th>
                                        <th scope="col" class="text-center">Список</th>
                                        <th scope="col" class="text-center">Добавлять</th>
                                        <th scope="col" class="text-center">Просмотривать</th>
                                        <th scope="col" class="text-center">Редактировать</th>
                                        <th scope="col" class="text-center">Активировать</th>
                                        <th scope="col" class="text-center">Аннулировать</th>
                                        <th scope="col" class="text-center">История</th>
                                        <th scope="col" class="text-center">Удалить</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th colspan="10" class="text-center">НАВИГАЦИЯ</th>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="align-middle">Сотрудники</th>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerMenu', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workerMenu', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerIndex', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workerIndex', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerCreate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workerCreate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerView', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workerView', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerUpdate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workerUpdate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerActive', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workerActive', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerBlocked', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workerBlocked', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workerHistory', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workerHistory', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-right "><em><small>Деятельность</small></em></th>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workMenu', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workMenu', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workIndex', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workIndex', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workCreate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workCreate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workView', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workView', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workUpdate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workUpdate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workActive', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workActive', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'workBlocked', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('workBlocked', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-right "><em><small>Сертификаты</small></em></th>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateMenu', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('certificateMenu', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateIndex', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('certificateIndex', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateCreate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('certificateCreate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateView', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('certificateView', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateUpdate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('certificateUpdate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateActive', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('certificateActive', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'certificateBlocked', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('certificateBlocked', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-right "><em><small>Справки</small></em></th>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceMenu', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('referenceMenu', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceIndex', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('referenceIndex', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceCreate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('referenceCreate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceView', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('referenceView', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceUpdate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('referenceUpdate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceActive', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('referenceActive', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'referenceBlocked', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('referenceBlocked', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-right "><em><small>Вакцинация</small></em></th>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationMenu', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('vaccinationMenu', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationIndex', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('vaccinationIndex', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationCreate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('vaccinationCreate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationView', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('vaccinationView', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationUpdate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('vaccinationUpdate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationActive', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('vaccinationActive', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'vaccinationBlocked', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('vaccinationBlocked', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-right "><em><small>Файлы</small></em></th>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileMenu', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('fileMenu', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileIndex', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('fileIndex', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileCreate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('fileCreate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileView', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('fileView', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileUpdate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('fileUpdate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileActive', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('fileActive', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileBlocked', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('fileBlocked', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'fileDelete', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('fileDelete', $roleName)])->label('') ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="align-middle">Последняя активность</th>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th colspan="10" class="text-center">СПРАВОЧНИКИ</th>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="align-middle">Подразделения</th>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="align-middle">Отделения</th>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="align-middle">Контрагенты ЮЛ</th>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-right "><em><small>Адреса</small></em></th>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-right "><em><small>Контакты</small></em></th>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="align-middle">Контрагенты ФЛ</th>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-right "><em><small>Паспорт</small></em></th>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th class="align-middle text-right "><em><small>Адреса</small></em></th>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle"></td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="align-middle">Должности</th>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionMenu', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('positionMenu', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionIndex', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('positionIndex', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionCreate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('positionCreate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionView', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('positionView', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionUpdate', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('positionUpdate', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionActive', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('positionActive', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionBlocked', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('positionBlocked', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"><?= $form->field($permissions, 'positionHistory', ['options' => ['tag' => false]])->checkbox(['checked'=> $permissions->checked('positionHistory', $roleName)])->label('') ?></td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="align-middle">Специальности</th>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="align-middle">Справки</th>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="align-middle">Вакцины</th>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle">1</td>
                                        <td class="text-center align-middle"></td>
                                    </tr>
                                    </tbody>
                                </table>
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