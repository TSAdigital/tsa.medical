<?php

/* @var $this yii\web\View */
/* @var $model app\models\Work */
/* @var $worker app\models\Worker */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = 'Новая Должность';
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($worker->getCounterparty_name(), 40, '...'), 'url' => ['view', 'id' => $worker->id]];
$this->params['breadcrumbs'][] = ['label' => 'Деятельность', 'url' => ['view', 'id' => $worker->id, '#' => 'work/']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form' => 'work']),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['view', 'id' => $worker->id, '#' => 'work'], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?=$this->render('_form_work', [
                        'model' => $model
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>