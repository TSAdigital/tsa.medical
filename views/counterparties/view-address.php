<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Counterparty */
/* @var $address app\models\Address */

$this->title = 'Адрес - ' . StringHelper::truncate($model->name, 50, '...');
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты ЮЛ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->name, 15, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Адрес', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $address->getAddressName();
$this->params['buttons'] = [
    'update' => $address->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update-address', 'id' => $model->id, 'address' => $address->id], ['class' => 'btn btn-app']) : false,
    'block' => $address->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked-address', 'id' => $model->id, 'address' => $address->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Аннулировать должность?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $address->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active-address', 'id' => $model->id, 'address' => $address->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Активировать должность?',
            'method' => 'post',
        ],
    ]) : false,
    'history' => Html::a('<i class="fas fa-history text-info"></i>История', ['history', 'id' => $model->id], ['class' => 'btn btn-app']),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['counterparties/view', 'id' => $model->id], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <?= DetailView::widget([
                        'model' => $address,
                        'attributes' => [
                            [
                                'attribute' => 'type',
                                'value' => $address->getAddressName(),
                                'captionOptions' => ['width' => '200px'],
                            ],
                            'index',
                            [
                                'attribute' => 'status',
                                'value' => $address->getStatusName(),
                                'captionOptions' => ['width' => '200px'],
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