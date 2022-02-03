<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Division */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Отделения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
    'update' => $model->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-app']) : false,
    'block' => $model->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked', 'id' => $model->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Аннулировать должность?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $model->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active', 'id' => $model->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Активировать должность?',
            'method' => 'post',
        ],
    ]) : false,
    'history' => Html::a('<i class="fas fa-history text-info"></i>История', ['history', 'id' => $model->id], ['class' => 'btn btn-app']),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/index'], ['class' => 'btn btn-app'])
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
                            'name',
                            [
                                'attribute' => 'department_name',
                                'captionOptions' => ['width' => '200px'],
                            ],
                            [
                                'attribute' => 'status',
                                'value' => $model->getStatusName(),
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