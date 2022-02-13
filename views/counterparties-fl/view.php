<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\CounterpartyFl */
/* @var $passport app\models\Passport */

$this->title = $model->last_name . ' ' . $model->firs_name . ' ' . $model->middle_name;
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты ФЛ', 'url' => ['index']];
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
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['counterparties-fl/index'], ['class' => 'btn btn-app'])
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
                        <li class="nav-item"><a class="nav-link" href="#contact" data-toggle="tab">Контакты</a></li>
                    </ul>
                </div>
                <div class="card-body pb-1">
                    <div class="tab-content" data-enable-remember="true">
                        <div class="active tab-pane" id="base">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'last_name',
                                        'captionOptions' => ['width' => '250px'],
                                    ],
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
                            <div class="row">
                                <div class="table-responsive">
                                    <?php
                                        $tempalte = '
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                 <tr>
                                                    <th scope="col" class="text-center align-middle">Серия</th>
                                                    <th scope="col" class="text-center align-middle">Номер</th>
                                                    <th scope="col" class="text-center align-middle">Дата выдачи</th>
                                                    <th scope="col" class="text-center align-middle">Код подразделения</th>
                                                    <th scope="col" class="align-middle">Кто выдал</th>
                                                    <th scope="col" class="align-middle">Место рождения</th>
                                                    <th scope="col" class="text-center align-middle">Статус</th>
                                                    <th scope="col" class="text-center align-middle">'. Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-passport', 'id' => $model->id]) .'
                                                </tr>      
                                                </thead>
                                                <tbody>
                                                    {items}
                                                </tbody>
                                            </table>
                                            {pager}
                                        ';
                                    ?>

                                    <?= ListView::widget([
                                        'dataProvider' => $passport,
                                        'layout' => $tempalte,

                                        'emptyText' => Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-passport', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block']),
                                        'itemOptions' => [
                                            'tag' => false,
                                        ],
                                        'viewParams'=> ['counterparty' => $model],
                                        'itemView' => '_list_passport',
                                        'pager' => [
                                            'class' => 'yii\bootstrap4\LinkPager',
                                        ],
                                    ]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="address">

                        </div>
                        <div class="tab-pane" id="contact">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>