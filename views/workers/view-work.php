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
$this->params['breadcrumbs'][] = StringHelper::truncate($work->getPosition_name(), 10, '...');
$disabled_update = (Yii::$app->user->can('workUpdate') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$disabled_block = (Yii::$app->user->can('workBlocked') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$disabled_active = (Yii::$app->user->can('workActive') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$this->params['buttons'] = [
    'update' => $work->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update-work', 'id' => $model->id, 'work' => $work->id], ['class' => 'btn btn-app' . $disabled_update]) : false,
    'block' => $work->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked-work', 'id' => $model->id, 'work' => $work->id], [
        'class' => 'btn btn-app' . $disabled_block ,
        'data' => [
            'confirm' => 'Аннулировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $work->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active-work', 'id' => $model->id, 'work' => $work->id], [
        'class' => 'btn btn-app' . $disabled_active,
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