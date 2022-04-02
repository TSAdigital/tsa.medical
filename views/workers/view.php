<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $age app\models\CounterpartyFl */

$this->title = $model->getCounterparty_name();
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
    'update' => $model->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-app']) : false,
    'block' => $model->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked', 'id' => $model->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Аннулировать сотрудника?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $model->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active', 'id' => $model->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Активировать сотрудника?',
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
                <div class="card-header p-2">
                    <ul class="nav nav-pills nav-pos">
                        <li class="nav-item"><a class="nav-link active" href="#base" data-toggle="tab">Основное</a></li>
                        <li class="nav-item"><a class="nav-link" href="#work" data-toggle="tab">Деятельность</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact" data-toggle="tab">Контакты</a></li>
                    </ul>
                </div>
                <div class="card-body pb-1">
                    <div class="tab-content">
                        <div class="active tab-pane" id="base">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => [
                                    'class' => 'table table-bordered table-striped',
                                ],
                                'attributes' => [
                                    [
                                        'attribute' => 'counterparty_name',
                                        'captionOptions' => ['width' => '220px'],
                                        'value' => Html::a($model->getCounterparty_name(), ['counterparties-fl/view', 'id' => $model->counterparty_id], ['target'=>'_blank']),
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'age',
                                        'value' => Yii::$app->inflection->textizeTimeRange(new DateInterval('P'.$age.'Y')),
                                    ],
                                    'department_name',
                                    'division_name',
                                    [
                                        'attribute' => 'status',
                                        'value' => $model->getStatusName(),
                                    ],
                                    'created_at:datetime',
                                    'updated_at:datetime',
                                ],
                            ]) ?>
                        </div>
                        <div class="tab-pane" id="work">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => [
                                    'class' => 'table table-bordered table-striped',
                                ],
                                'attributes' => [
                                    [
                                        'attribute' => 'position_name',
                                        'captionOptions' => ['width' => '240px'],
                                    ],
                                ],
                            ]) ?>
                        </div>
                        <div class="tab-pane" id="contact">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => [
                                    'class' => 'table table-bordered table-striped',
                                ],
                                'attributes' => [
                                    'phone:phone',
                                    [
                                        'attribute' => 'extension_phone',
                                        'captionOptions' => ['width' => '240px'],
                                    ],
                                    'email:email',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>