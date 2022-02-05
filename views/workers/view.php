<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Worker */

$this->title = $model->last_name . ' ' . $model->firs_name . ' ' . $model->middle_name;
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
    'update' => $model->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-app']) : false,
    'block' => $model->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked', 'id' => $model->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Аннулировать сотрудника?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $model->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active', 'id' => $model->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Активировать сотрудника?',
            'method' => 'post',
        ],
    ]) : false,
    'history' => Html::a('<i class="fas fa-history text-info"></i>История', ['history', 'id' => $model->id], ['class' => 'btn btn-app']),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/index'], ['class' => 'btn btn-app'])
];
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#base" data-toggle="tab">Основное</a></li>
                        <li class="nav-item"><a class="nav-link" href="#passport" data-toggle="tab">Паспорт</a></li>
                        <li class="nav-item"><a class="nav-link" href="#address" data-toggle="tab">Адрес</a></li>
                        <li class="nav-item"><a class="nav-link" href="#work" data-toggle="tab">Деятельность</a></li>
                    </ul>
                </div>
                <div class="card-body pb-1">
                    <div class="tab-content">
                        <div class="active tab-pane" id="base">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => [
                                    'class' => 'table table-bordered table-striped',
                                ],
                                'attributes' => [
                                    [
                                        'attribute' => 'department_name',
                                        'captionOptions' => ['width' => '200px'],
                                    ],
                                    'division_name',
                                    'last_name',
                                    'firs_name',
                                    'middle_name',
                                    'birthdate:date',
                                    [
                                        'attribute' => 'gender',
                                        'captionOptions' => ['width' => '200px'],
                                        'value' => $model->getGender(),
                                    ],
                                    'snils:snils',
                                    'inn',
                                    [
                                        'attribute' => 'status',
                                        'value' => $model->getStatusName(),
                                    ],
                                    'created_at:datetime',
                                    'updated_at:datetime',
                                ],
                            ]) ?>
                        </div>
                        <div class="tab-pane" id="passport">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => [
                                    'class' => 'table table-bordered table-striped',
                                ],
                                'attributes' => [
                                    'passport_serial:passportSerial',
                                    [
                                        'attribute' => 'passport_number',
                                        'captionOptions' => ['width' => '200px'],

                                    ],
                                    'passport_date:date',
                                    'passport_issued',
                                    'passport_department_code:passportDepartmentCode',
                                    'passport_birthplace',
                                ],
                            ]) ?>
                        </div>
                        <div class="tab-pane" id="address">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => [
                                    'class' => 'table table-bordered table-striped',
                                ],
                                'attributes' => [
                                    [
                                        'attribute' => 'address_index',
                                        'captionOptions' => ['width' => '200px'],
                                    ],
                                    'address_country',
                                    'address_region',
                                    'address_district',
                                    'address_city',
                                    'address_locality',
                                    'address_street',
                                    'address_house',
                                    'address_body',
                                    'address_building',
                                    'address_apartment',
                                ],
                            ]) ?>
                        </div>
                        <div class="tab-pane" id="work">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => [
                                    'class' => 'table table-bordered table-striped',
                                ],
                                'attributes' => [
                                    [
                                        'attribute' => 'position_name',
                                        'captionOptions' => ['width' => '210px'],
                                    ],
                                    'work_document',
                                    'work_document_number',
                                    'work_document_date:date',
                                    'work_start:date',
                                    'work_end:date',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>