<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\CounterpartyFl */
/* @var $passport app\models\Passport */
/* @var $address app\models\AddressFl */

$this->title = StringHelper::truncate($model->last_name . ' ' . $model->first_name . ' ' . $model->middle_name, 50, '...');
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты ФЛ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$disabled_update = (Yii::$app->user->can('counterpartyFlUpdate') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$disabled_block = (Yii::$app->user->can('counterpartyFlBlocked') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$disabled_active = (Yii::$app->user->can('counterpartyFlActive') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$disabled_history = (Yii::$app->user->can('counterpartyFlHistory') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
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
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['counterparties-fl/index'], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills" id="myTab">
                        <li class="nav-item"><a class="nav-link active" href="#base" data-toggle="tab">Основное</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact" data-toggle="tab">Контакты</a></li>
                        <?= (Yii::$app->user->can('counterpartyFlPassportMenu') or Yii::$app->user->can('admin')) ? '<li class="nav-item"><a class="nav-link" href="#passport" data-toggle="tab">Паспорт</a></li>' : NULL; ?>
                        <?= (Yii::$app->user->can('counterpartyFlAddressMenu') or Yii::$app->user->can('admin')) ? '<li class="nav-item"><a class="nav-link" href="#address" data-toggle="tab">Адреса</a></li>' : NULL; ?>
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
                                    'first_name',
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
                        <div class="tab-pane" id="contact">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'phone',
                                        'captionOptions' => ['width' => '250px'],
                                        'format' => 'raw',
                                        'value' => Yii::$app->formatter->asPhone($model->phone)
                                    ],
                                    'email:email',
                                ],
                            ]) ?>
                        </div>
                        <div class="tab-pane" id="passport">
                            <div class="table-responsive">
                                <?php
                                if(Yii::$app->user->can('counterpartyFlPassportIndex') or Yii::$app->user->can('admin')) :
                                $button_add_passport = ($model->status == 10 and (Yii::$app->user->can('counterpartyFlPassportCreate') or Yii::$app->user->can('admin'))) ? Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-passport', 'id' => $model->id], ['class' => 'btn m-0 p-0']) : Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-passport', 'id' => $model->id], ['class' => 'btn disabled m-0 p-0']);
                                $template = '
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
                                            <th scope="col" class="text-center align-middle">'. $button_add_passport .'</th>
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
                                    'layout' => $template,
                                    'emptyText' => ($model->status == 10 and (Yii::$app->user->can('counterpartyFlPassportCreate') or Yii::$app->user->can('admin'))) ? Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-passport', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block']) : Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-passport', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block disabled']),
                                    'emptyTextOptions' => ['class' => 'empty mb-3'],
                                    'itemOptions' => [
                                        'tag' => false,
                                    ],
                                    'viewParams'=> ['counterparty' => $model],
                                    'itemView' => '_list_passport',
                                    'pager' => [
                                        'class' => 'yii\bootstrap4\LinkPager',
                                    ],
                                ]); ?>
                                <?php else: ?>
                                    <p>У вас нет разрешения на просмотр</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="address">
                            <div class="table-responsive">
                                <?php
                                if(Yii::$app->user->can('counterpartyFlAddressIndex') or Yii::$app->user->can('admin')) :
                                $button_add_address = ($model->status == 10 and (Yii::$app->user->can('counterpartyFlAddressCreate') or Yii::$app->user->can('admin'))) ? Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-address', 'id' => $model->id], ['class' => 'btn m-0 p-0']) : Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-address', 'id' => $model->id], ['class' => 'btn disabled m-0 p-0']);
                                $template = '
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
                                                <th scope="col" class="align-middle">Квартира</th>
                                                <th scope="col" class="text-center align-middle">Статус</th>
                                                <th scope="col" class="text-center align-middle">'. $button_add_address .'</th>
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
                                    'dataProvider' => $address,
                                    'layout' => $template,
                                    'emptyText' => ($model->status == 10 and (Yii::$app->user->can('counterpartyFlAddressCreate') or Yii::$app->user->can('admin'))) ? Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-address', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block']) : Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-address', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block disabled']),
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>