<?php

/* @var $this yii\web\View */
/* @var $model app\models\Contact */
/* @var $counterparty app\models\Counterparty */

use yii\helpers\Html;

$this->title = 'Новый Контакт';
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты ЮЛ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $counterparty->name, 'url' => ['view', 'id' => $counterparty->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form'=>"contact"]),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['view', 'id' => $counterparty->id], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?=$this->render('_form_contact', [
                        'model' => $model
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>