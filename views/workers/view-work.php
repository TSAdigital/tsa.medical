<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $work app\models\Work */

$this->title = StringHelper::truncate($model->getCounterparty_name(), 50, '...');
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->getCounterparty_name(), 30, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Деятельность', 'url' => ['view', 'id' => $model->id, '#' => 'work/']];
$this->params['breadcrumbs'][] = $work->getPosition_name();
$this->params['buttons'] = [
    'update' => $work->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update-work', 'id' => $model->id, 'work' => $work->id], ['class' => 'btn btn-app']) : false,
    'block' => $work->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked-work', 'id' => $model->id, 'work' => $work->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Аннулировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $work->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active-work', 'id' => $model->id, 'work' => $work->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Активировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/view', 'id' => $model->id, '#' => 'work/'], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <?= DetailView::widget([
                        'model' => $work,
                        'attributes' => [
                            [
                                'attribute' => 'department_name',
                                'captionOptions' => ['width' => '260px'],
                            ],
                            'division_name',
                            [
                                'attribute' => 'busyness',
                                'value' => $work->getEmploymentName(),
                            ],
                            'position_name',
                            'work_start_date',
                            'bet',
                            'document',
                            'document_number',
                            'document_date',
                            'work_end_date',

                            [
                                'attribute' => 'status',
                                'value' => $work->getStatusName(),
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