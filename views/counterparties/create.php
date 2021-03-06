<?php

/* @var $this yii\web\View */
/* @var $model app\models\Counterparty */

use yii\helpers\Html;

$this->title = 'Новый Контрагент';
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form'=>"counterparty"]),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['counterparties/index'], ['class' => 'btn btn-app'])
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