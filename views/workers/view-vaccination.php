<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $vaccination app\models\Vaccination */

$this->title = StringHelper::truncate($model->getCounterparty_name(), 50, '...');
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->getCounterparty_name(), 30, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Вакцинация', 'url' => ['view', 'id' => $model->id, '#' => 'vaccination/']];
$this->params['breadcrumbs'][] = StringHelper::truncate($vaccination->getCounterparty_name(), 10, '...');
$disabled_update = (Yii::$app->user->can('vaccinationUpdate') or Yii::$app->user->can('admin')) ?: 'disabled';
$disabled_block = (Yii::$app->user->can('vaccinationBlocked') or Yii::$app->user->can('admin')) ?: 'disabled';
$disabled_active = (Yii::$app->user->can('vaccinationActive') or Yii::$app->user->can('admin')) ?: 'disabled';
$this->params['buttons'] = [
    'update' => $vaccination->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update-vaccination', 'id' => $model->id, 'vaccination' => $vaccination->id], ['class' => 'btn btn-app ' . $disabled_update]) : false,
    'block' => $vaccination->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked-vaccination', 'id' => $model->id, 'vaccination' => $vaccination->id], [
        'class' => 'btn btn-app ' . $disabled_block,
        'data' => [
            'confirm' => 'Аннулировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $vaccination->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active-vaccination', 'id' => $model->id, 'vaccination' => $vaccination->id], [
        'class' => 'btn btn-app ' . $disabled_active,
        'data' => [
            'confirm' => 'Активировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/view', 'id' => $model->id, '#' => 'vaccination/'], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <?= DetailView::widget([
                        'model' => $vaccination,
                        'attributes' => [
                            [
                                'attribute' => 'vaccine_id',
                                'captionOptions' => ['width' => '260px'],
                                'value' => $vaccination->getVaccine_name(),
                            ],
                            [
                                'attribute' => 'counterparty_id',
                                'value' =>  Html::a($vaccination->getCounterparty_name(), ['counterparties/view', 'id' => $vaccination->counterparty_id], ['target'=>'_blank']),
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'revaccination',
                                'value' => $vaccination->revaccination == 10 ? 'Да' : 'Нет',
                            ],
                            'start_date',
                            'end_date',
                            [
                                'attribute' => 'status',
                                'value' => $vaccination->getStatusName(),
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