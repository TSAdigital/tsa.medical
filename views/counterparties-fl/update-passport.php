<?php

/* @var $this yii\web\View */
/* @var $model app\models\Passport */
/* @var $counterparty app\models\CounterpartyFl */

use yii\helpers\Html;

$this->title = 'Редактирование: Паспорт';
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $counterparty->last_name . ' ' . $counterparty->firs_name . ' ' . $counterparty->middle_name, 'url' => ['view', 'id' => $counterparty->id]];
$this->params['breadcrumbs'][] = ['label' => 'Паспорт', 'url' => ['view', 'id' => $counterparty->id]];;
$this->params['breadcrumbs'][] = 'Редактирование';
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form'=>"passport"]),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['view', 'id' => $counterparty->id], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?=$this->render('_form_passport', [
                        'model' => $model,
                        'counterparty' => $counterparty
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>