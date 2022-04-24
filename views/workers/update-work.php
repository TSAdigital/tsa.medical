<?php

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $work app\models\Work */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = 'Редактирование: должность ' . StringHelper::truncate($work->getPosition_name(), 32, '...');
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->getCounterparty_name(), 20, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Деятельность', 'url' => ['view', 'id' => $model->id, '#' => 'work/']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($work->getPosition_name(), 10, '...'), 'url' => ['view-work', 'id' => $model->id, 'work' => $work->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form' => 'work']),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/view-work', 'id' => $model->id, 'work' => $work->id ], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?=$this->render('_form_work', [
                        'model' => $work,
                        'work' => $model
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>