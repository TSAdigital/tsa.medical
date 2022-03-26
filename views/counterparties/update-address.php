<?php

/* @var $this yii\web\View */
/* @var $model app\models\Address */
/* @var $counterparty app\models\Counterparty */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = 'Редактирование: ' . $model->getAddressName() . ' адрес';
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты ЮЛ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($counterparty->name, 15, '...'), 'url' => ['view', 'id' => $counterparty->id]];
$this->params['breadcrumbs'][] = ['label' => 'Адрес', 'url' => ['view', 'id' => $counterparty->id]];
$this->params['breadcrumbs'][] = ['label' => $model->getAddressName(), 'url' => ['view-address', 'id' => $counterparty->id, 'address' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form'=>"address"]),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['view-address', 'id' => $counterparty->id, 'address' => $model->id], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?=$this->render('_form_address', [
                        'model' => $model,
                        'counterparty' => $counterparty
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>