<?php

/* @var $this yii\web\View */
/* @var $model app\models\Counterparty */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = 'Редактирование: ' . StringHelper::truncate($model->name, 40, '...');
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты ЮЛ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->name, 45, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form'=>"counterparty"]),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['view', 'id' => $model->id], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                    <?=$this->render('_form', [
                        'model' => $model
                    ]) ?>

            </div>
        </div>
    </div>
</div>