<?php

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $vaccination app\models\Vaccination */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = 'Редактирование: данные о вакцинации ' . StringHelper::truncate($vaccination->getVaccine_name(), 30, '...');
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->getCounterparty_name(), 20, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Вакцинация', 'url' => ['view', 'id' => $model->id, '#' => 'vaccination/']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($vaccination->getVaccine_name(), 12, '...'), 'url' => ['view-vaccination', 'id' => $model->id, 'vaccination' => $vaccination->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form' => 'vaccination']),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/view-vaccination', 'id' => $model->id, 'vaccination' => $vaccination->id ], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?=$this->render('_form_vaccination', [
                        'model' => $vaccination,
                        'work' => $model
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>