<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Counterparty */
/* @var $address app\models\Address */

$this->title = StringHelper::truncate($model->name, 50, '...');
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты ЮЛ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->name, 30, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Адреса', 'url' => ['view', 'id' => $model->id, '#' => 'address/']];
$this->params['breadcrumbs'][] = $address->getAddressName();
$disabled_update = (Yii::$app->user->can('counterpartyAddressUpdate') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$disabled_block = (Yii::$app->user->can('counterpartyAddressBlocked') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$disabled_active = (Yii::$app->user->can('counterpartyAddressActive') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$this->params['buttons'] = [
    'update' => $address->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update-address', 'id' => $model->id, 'address' => $address->id], ['class' => 'btn btn-app' . $disabled_update]) : false,
    'block' => $address->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked-address', 'id' => $model->id, 'address' => $address->id], [
        'class' => 'btn btn-app' . $disabled_block,
        'data' => [
            'confirm' => 'Аннулировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $address->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active-address', 'id' => $model->id, 'address' => $address->id], [
        'class' => 'btn btn-app' . $disabled_active,
        'data' => [
            'confirm' => 'Активировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['counterparties/view', 'id' => $model->id, '#' => 'address/'], ['class' => 'btn btn-app'])
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
                            'country',
                            'region',
                            'district',
                            'city',
                            'locality',
                            'street',
                            'house',
                            'body',
                            'building',
                            'office',
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