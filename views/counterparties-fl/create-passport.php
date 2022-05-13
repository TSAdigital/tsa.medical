<?php

/* @var $this yii\web\View */
/* @var $model app\models\Passport */
/* @var $counterparty app\models\CounterpartyFl */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = 'Новый Паспорт';
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты ФЛ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($counterparty->last_name . ' ' . $counterparty->first_name . ' ' . $counterparty->middle_name, 40, '...'), 'url' => ['view', 'id' => $counterparty->id]];
$this->params['breadcrumbs'][] = ['label' => 'Паспорт', 'url' => ['view', 'id' => $counterparty->id, '#' => 'passport/']];
$this->params['breadcrumbs'][] = $this->title;
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
                        'model' => $model
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>