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
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Раздел</th>
                                    <th scope="col" class="text-center">Меню</th>
                                    <th scope="col" class="text-center">Главная</th>
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
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                </tr>
                                <tr>
                                    <th class="align-middle text-right "><em><small>Сертификаты</small></em></th>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                </tr>
                                <tr>
                                    <th class="align-middle text-right "><em><small>Справки</small></em></th>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                </tr>
                                <tr>
                                    <th class="align-middle text-right "><em><small>Вакцинация</small></em></th>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                </tr>
                                <tr>
                                    <th class="align-middle text-right "><em><small>Файлы</small></em></th>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
                                    <td class="text-center align-middle"></td>
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
                                </tbody>
                            </table>
                            <div class="form-group">
                                <?= Html::a('<i class="far fa-save text-success"></i>Сохранить', ['permissions', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block', 'data' => [
                                    'method' => 'post',
                                    ],
                                ]) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>