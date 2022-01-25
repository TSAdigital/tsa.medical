<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p>
                        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= $model->status == 9 ? Html::a('Разблокировать', ['user-active', 'id' => $model->id], [
                            'class' => 'btn btn-success',
                            'data' => [
                                'confirm' => 'Активировать пользователя?',
                                'method' => 'post',
                            ],
                        ]): '' ?>
                        <?= $model->status == 10 ? Html::a('Заблокировать', ['user-blocked', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Заблокировать пользователя?',
                                'method' => 'post',
                            ],
                        ]) : '' ?>
                    </p>
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