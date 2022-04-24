<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $reference app\models\Reference */

$this->title = StringHelper::truncate($model->getCounterparty_name(), 50, '...');
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->getCounterparty_name(), 30, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Справки', 'url' => ['view', 'id' => $model->id, '#' => 'reference/']];
$this->params['breadcrumbs'][] = StringHelper::truncate($reference->getReference_type_name(), 10, '...');
$this->params['buttons'] = [
    'update' => $reference->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update-reference', 'id' => $model->id, 'reference' => $reference->id], ['class' => 'btn btn-app']) : false,
    'block' => $reference->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked-reference', 'id' => $model->id, 'reference' => $reference->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Аннулировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $reference->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active-reference', 'id' => $model->id, 'reference' => $reference->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Активировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/view', 'id' => $model->id, '#' => 'reference/'], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <?= DetailView::widget([
                        'model' => $reference,
                        'attributes' => [
                            [
                                'attribute' => 'reference_type_id',
                                'captionOptions' => ['width' => '260px'],
                                'value' => $reference->getReference_type_name(),
                            ],
                            [
                                'attribute' => 'counterparty_id',
                                'value' =>  Html::a($reference->getCounterparty_name(), ['counterparties/view', 'id' => $reference->counterparty_id], ['target'=>'_blank']),
                                'format' => 'raw',
                            ],
                            'start_date',
                            'end_date',
                            [
                                'attribute' => 'status',
                                'value' => $reference->getStatusName(),
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