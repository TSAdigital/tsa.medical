<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $certificate app\models\Certificate */

$this->title = StringHelper::truncate($model->getCounterparty_name(), 50, '...');
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->getCounterparty_name(), 30, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Сертификаты', 'url' => ['view', 'id' => $model->id, '#' => 'certificate/']];
$this->params['breadcrumbs'][] = StringHelper::truncate($certificate->getSpecialization_name(), 10, '...');
$this->params['buttons'] = [
    'update' => $certificate->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update-certificate', 'id' => $model->id, 'certificate' => $certificate->id], ['class' => 'btn btn-app']) : false,
    'block' => $certificate->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked-certificate', 'id' => $model->id, 'certificate' => $certificate->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Аннулировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $certificate->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active-certificate', 'id' => $model->id, 'certificate' => $certificate->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Активировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/view', 'id' => $model->id, '#' => 'certificate/'], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <?= DetailView::widget([
                        'model' => $certificate,
                        'attributes' => [
                            [
                                'attribute' => 'counterparty_id',
                                'captionOptions' => ['width' => '260px'],
                                'value' =>  Html::a($certificate->getCounterparty_name(), ['counterparties/view', 'id' => $certificate->counterparty_id], ['target'=>'_blank']),
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'specialization_id',
                                'value' =>  $certificate->getSpecialization_name(),
                            ],
                            'serial',
                            'number',
                            'start_date',
                            'end_date',
                            [
                                'attribute' => 'status',
                                'value' => $certificate->getStatusName(),
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