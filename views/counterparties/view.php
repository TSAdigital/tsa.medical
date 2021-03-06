<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Counterparty */
/* @var $address app\models\Address */
/* @var $contact app\models\Contact */

$this->title = StringHelper::truncate($model->name, 50, '...');
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты ЮЛ', 'url' => ['index']];
$this->params['breadcrumbs'][] = StringHelper::truncate($model->name, 50, '...');
$disabled_update = (Yii::$app->user->can('counterpartyUpdate') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$disabled_block = (Yii::$app->user->can('counterpartyBlocked') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$disabled_active = (Yii::$app->user->can('counterpartyActive') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$disabled_history = (Yii::$app->user->can('counterpartyHistory') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$this->params['buttons'] = [
    'update' => $model->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-app' . $disabled_update]) : false,
    'block' => $model->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked', 'id' => $model->id], [
        'class' => 'btn btn-app' . $disabled_block,
        'data' => [
            'confirm' => 'Аннулировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $model->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active', 'id' => $model->id], [
        'class' => 'btn btn-app' . $disabled_active,
        'data' => [
            'confirm' => 'Активировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'history' => Html::a('<i class="fas fa-history text-info"></i>История', ['history', 'id' => $model->id], ['class' => 'btn btn-app' . $disabled_history]),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['counterparties/index'], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills" id="myTab">
                        <li class="nav-item"><a class="nav-link active" href="#base" data-toggle="tab">Основное</a></li>
                        <li class="nav-item"><a class="nav-link" href="#director" data-toggle="tab">Руководитель</a></li>
                        <?= (Yii::$app->user->can('counterpartyAddressMenu') or Yii::$app->user->can('admin')) ? '<li class="nav-item"><a class="nav-link" href="#address" data-toggle="tab">Адреса</a></li>' : NULL; ?>
                        <?= (Yii::$app->user->can('counterpartyContactMenu') or Yii::$app->user->can('admin')) ? '<li class="nav-item"><a class="nav-link" href="#contact" data-toggle="tab">Контакты</a></li>' : NULL; ?>
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
                                    'director_first_name',
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
                            if(Yii::$app->user->can('counterpartyAddressIndex') or Yii::$app->user->can('admin')) :
                            $button_add_address = ($model->status == 10 and (Yii::$app->user->can('counterpartyAddressCreate') or Yii::$app->user->can('admin'))) ? Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-address', 'id' => $model->id], ['class' => 'btn m-0 p-0']) : Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-address', 'id' => $model->id], ['class' => 'btn disabled m-0 p-0']);
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
                                'emptyText' => ($model->status == 10 and (Yii::$app->user->can('counterpartyAddressCreate') or Yii::$app->user->can('admin'))) ? Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-address', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block']) : Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-address', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block disabled']),
                                'emptyTextOptions' => ['class' => 'empty mb-3'],
                                'itemOptions' => [
                                    'tag' => false,
                                ],
                                'viewParams'=> ['counterparty' => $model],
                                'itemView' => '_list_address',
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',


                                ],
                            ]); ?>
                            <?php else: ?>
                                <p>У вас нет разрешения на просмотр</p>
                            <?php endif; ?>
                        </div>
                        <div class="tab-pane" id="contact">

                            <?php
                            if(Yii::$app->user->can('counterpartyContactIndex') or Yii::$app->user->can('admin')) :
                            $button_add_contact = ($model->status == 10 and (Yii::$app->user->can('counterpartyContactCreate') or Yii::$app->user->can('admin'))) ? Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-contact', 'id' => $model->id], ['class' => 'btn m-0 p-0']) : Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-contact', 'id' => $model->id], ['class' => 'btn disabled m-0 p-0']);
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
                                'emptyText' => ($model->status == 10 and (Yii::$app->user->can('counterpartyContactCreate') or Yii::$app->user->can('admin'))) ? Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-contact', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block']) : Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-contact', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block disabled']),
                                'emptyTextOptions' => ['class' => 'empty mb-3'],
                                'itemOptions' => [
                                    'tag' => false,
                                ],
                                'viewParams'=> ['counterparty' => $model],
                                'itemView' => '_list_contact',
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',
                                ],
                            ]); ?>
                            <?php else: ?>
                                <p>У вас нет разрешения на просмотр</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>