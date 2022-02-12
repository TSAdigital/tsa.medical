<?php

/* @var $this yii\web\View */
/* @var $model app\models\Passport */
/* @var $counterparty app\models\CounterpartyFl */

$this->title = 'Редактирование: Паспорт';
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $counterparty->last_name . ' ' . $counterparty->firs_name . ' ' . $counterparty->middle_name, 'url' => ['view', 'id' => $counterparty->id]];
$this->params['breadcrumbs'][] = ['label' => 'Паспорт', 'url' => ['view', 'id' => $counterparty->id]];;
$this->params['breadcrumbs'][] = 'Редактирование';
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form_passport', [
                        'model' => $model,
                        'counterparty' => $counterparty
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>