<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Department */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Подразделения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
    'update' => Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-app mb-0']),
    'block' => $model->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['department-blocked', 'id' => $model->id], [
        'class' => 'btn btn-app mb-0',
        'data' => [
            'confirm' => 'Аннулировать подразделение?',
            'method' => 'post',
        ],
    ]) : '',
    'active' => $model->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['department-active', 'id' => $model->id], [
        'class' => 'btn btn-app mb-0',
        'data' => [
            'confirm' => 'Активировать подразделение?',
            'method' => 'post',
        ],
    ]) : '',
    'history' => Html::a('<i class="fas fa-history text-info"></i>История', ['update', 'id' => $model->id], ['class' => 'btn btn-app mb-0'])
];

\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid mt-1">
    <div class="card">
        <div class="card-body mb-0 pb-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 mb-0 pb-0">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'id',
                                'captionOptions' => ['width' => '250px'],
                            ],
                            'name',
                            [
                                'attribute' => 'status',
                                'value' => $model->getStatusName(),
                            ],
                            //'created_at',
                            //'updated_at',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
