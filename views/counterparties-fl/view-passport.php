<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CounterpartyFL */
/* @var $passport app\models\Passport */

$this->title = StringHelper::truncate($model->last_name . ' ' . $model->first_name . ' ' . $model->middle_name, 50, '...');
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты ФЛ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->last_name . ' ' . $model->first_name . ' ' . $model->middle_name, 30, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Паспорт', 'url' => ['view', 'id' => $model->id, '#' => 'passport/']];
$this->params['breadcrumbs'][] = $passport->passport_serial . ' ' . $passport->passport_number;
$this->params['buttons'] = [
    'update' => $passport->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update-passport', 'id' => $model->id, 'passport' => $passport->id], ['class' => 'btn btn-app']) : false,
    'block' => $passport->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked-passport', 'id' => $model->id, 'passport' => $passport->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Аннулировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $passport->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active-passport', 'id' => $model->id, 'passport' => $passport->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Активировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['counterparties-fl/view', 'id' => $model->id, '#' => 'passport/'], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <?= DetailView::widget([
                        'model' => $passport,
                        'attributes' => [
                            [
                                'attribute' => 'passport_serial',
                                'captionOptions' => ['width' => '200px'],
                            ],
                            'passport_number',
                            'passport_date',
                            'passport_issued',
                            'passport_department_code',
                            'passport_birthplace',
                            [
                                'attribute' => 'status',
                                'value' => $passport->getStatusName(),
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