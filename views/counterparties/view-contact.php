<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Counterparty */
/* @var $contact app\models\Contact */

$this->title = StringHelper::truncate($model->name, 50, '...');
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты ЮЛ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->name, 15, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Контакты', 'url' => ['view', 'id' => $model->id, '#' => 'contact']];
$this->params['breadcrumbs'][] = StringHelper::truncate($contact->name, 20, '...');
$this->params['buttons'] = [
    'update' => $contact->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update-contact', 'id' => $model->id, 'contact' => $contact->id], ['class' => 'btn btn-app']) : false,
    'block' => $contact->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked-contact', 'id' => $model->id, 'contact' => $contact->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Аннулировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $contact->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active-contact', 'id' => $model->id, 'contact' => $contact->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Активировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['counterparties/view', 'id' => $model->id, '#' => 'contact'], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <?= DetailView::widget([
                        'model' => $contact,
                        'attributes' => [
                            [
                                'attribute' => 'name',
                                'captionOptions' => ['width' => '200px'],
                            ],
                            'positionName',
                            'phone:phone',
                            'phone_extension',
                            'email:email',
                            [
                                'attribute' => 'status',
                                'value' => $contact->getStatusName(),
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