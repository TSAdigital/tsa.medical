<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
    'update' => Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-app']),
    'block' => $model->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Заблокировать', ['blocked', 'id' => $model->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Заблокировать пользователя?',
            'method' => 'post',
        ],
    ]) : '',
    'active' => $model->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Разблокировать', ['active', 'id' => $model->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Разблокировать пользователя?',
            'method' => 'post',
        ],
    ]) : '',
    'history' => Html::a('<i class="fas fa-history text-info"></i>История', ['history', 'id' => $model->id], ['class' => 'btn btn-app'])
];
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                     <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'id',
                                'captionOptions' => ['width' => '300px'],
                            ],
                            'username',
                            'email:email',
                            [
                                'attribute' => 'status',
                                'value' => $model->getStatusName(),
                            ],
                            [
                                'attribute' => 'roles',
                                'value' => $model->getRolesName(),
                            ],
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>