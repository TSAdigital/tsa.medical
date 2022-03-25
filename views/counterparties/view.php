<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Counterparty */
/* @var $address app\models\Address */
/* @var $contact app\models\Contact */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты', 'url' => ['index']];
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
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['counterparties/index'], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills nav-pos">
                        <li class="nav-item"><a class="nav-link active" href="#base" data-toggle="tab">Основное</a></li>
                        <li class="nav-item"><a class="nav-link" href="#director" data-toggle="tab">Руководитель</a></li>
                        <li class="nav-item"><a class="nav-link" href="#address" data-toggle="tab">Адреса</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact" data-toggle="tab">Контакты</a></li>
                    </ul>
                </div>
                <div class="card-body pb-1">
                    <div class="tab-content">
                        <div class="active tab-pane" id="base">

                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'name',
                                        'captionOptions' => ['width' => '250px'],
                                    ],
                                    'full_name',
                                    'inn',
                                    'kpp',
                                    'ogrn',
                                    'okpo',
                                    'phone:phone',
                                    'email:email',
                                    'web_site:url',
                                    [
                                        'attribute' => 'status',
                                        'value' => $model->getStatusName(),
                                    ],
                                    'created_at:datetime',
                                    'updated_at:datetime',
                                ],
                            ]) ?>

                        </div>
                        <div class="tab-pane" id="director">

                            <?= DetailView::widget([
                                'model' => $model,

                                'attributes' => [
                                    [
                                        'attribute' => 'director_last_name',
                                        'captionOptions' => ['width' => '250px'],
                                    ],
                                    'director_firs_name',
                                    'director_middle_name',
                                    [
                                        'attribute' => 'director_position',
                                        'value' => $model->getPositionName(),
                                    ],
                                    'director_document',
                                ],
                            ]) ?>

                        </div>
                        <div class="tab-pane" id="address">

                            <?php
                            $button_add_address = $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-address', 'id' => $model->id]) : null;
                            $tempalte = '
                                            <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                 <tr>
                                                    <th scope="col" class="align-middle">Тип</th>
                                                    <th scope="col" class="align-middle">Индекс</th>
                                                    <th scope="col" class="align-middle">Страна</th>
                                                    <th scope="col" class="align-middle">Регион</th>
                                                    <th scope="col" class="align-middle d-none">Район</th>
                                                    <th scope="col" class="align-middle">Город</th>
                                                    <th scope="col" class="align-middle d-none">Населенный пункт</th>
                                                    <th scope="col" class="align-middle">Улица</th>
                                                    <th scope="col" class="align-middle">Дом</th>
                                                    <th scope="col" class="align-middle d-none">Корпус</th>
                                                    <th scope="col" class="align-middle d-none">Строение</th>
                                                    <th scope="col" class="align-middle">Офис</th>
                                                    <th scope="col" class="text-center align-middle">Статус</th>
                                                    <th scope="col" class="text-center align-middle">'. $button_add_address .'</th>
                                                </tr>      
                                                </thead>
                                                <tbody>
                                                    {items}
                                                </tbody>
                                            </table>
                                            {pager}
                                            </div>
                                        ';
                            ?>

                            <?= ListView::widget([
                                'dataProvider' => $address,
                                'layout' => $tempalte,

                                'emptyText' => $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-address', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block']) : null,
                                'itemOptions' => [
                                    'tag' => false,
                                ],
                                'viewParams'=> ['counterparty' => $model],
                                'itemView' => '_list_address',
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',


                                ],
                            ]); ?>

                        </div>
                        <div class="tab-pane" id="contact">

                            <?php
                            $button_add_contact = $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-contact', 'id' => $model->id]) : null;
                            $tempalte = '
                                            <div class="table-responsive">
                                            <table class="table table-bordered table-striped ">
                                                <thead>
                                                 <tr>
                                                    <th scope="col" class="align-middle">Имя</th>
                                                    <th scope="col" class="align-middle">Должность</th>
                                                    <th scope="col" class="align-middle">Номер телефона</th>
                                                    <th scope="col" class="align-middle">Внутренний номер</th>
                                                    <th scope="col" class="align-middle">Адрес электронной почты</th>
                                                    <th scope="col" class="text-center align-middle">Статус</th>
                                                    <th scope="col" class="text-center align-middle">'. $button_add_contact .'</th>
                                                </tr>      
                                                </thead>
                                                <tbody>
                                                    {items}
                                                </tbody>
                                            </table>
                                            {pager}
                                            </div>
                                        ';
                            ?>

                            <?= ListView::widget([
                                'dataProvider' => $contact,
                                'layout' => $tempalte,

                                'emptyText' => $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-contact', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block']) : null,
                                'itemOptions' => [
                                    'tag' => false,
                                ],
                                'viewParams'=> ['counterparty' => $model],
                                'itemView' => '_list_contact',
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',
                                ],
                            ]); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>