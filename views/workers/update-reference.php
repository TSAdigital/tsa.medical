<?php

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $reference app\models\Reference */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = 'Редактирование: справки ' . $reference->getReference_type_name();
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->getCounterparty_name(), 20, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Справки', 'url' => ['view', 'id' => $model->id, '#' => 'reference/']];
$this->params['breadcrumbs'][] = ['label' => $reference->getReference_type_name(), 'url' => ['view-reference', 'id' => $model->id, 'reference' => $reference->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form' => 'reference']),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/view-reference', 'id' => $model->id, 'reference' => $reference->id ], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?=$this->render('_form_reference', [
                        'model' => $reference,
                        'work' => $model
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>