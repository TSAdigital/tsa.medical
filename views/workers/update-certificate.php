<?php

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $certificate app\models\Certificate */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = 'Редактирование: сертификат ' . StringHelper::truncate($certificate->getSpecialization_name(), 30, '...');
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->getCounterparty_name(), 20, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Сертификаты', 'url' => ['view', 'id' => $model->id, '#' => 'certificate/']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($certificate->getSpecialization_name(), 12, '...'), 'url' => ['view-certificate', 'id' => $model->id, 'certificate' => $certificate->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form' => 'certificate']),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/view-certificate', 'id' => $model->id, 'certificate' => $certificate->id ], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?=$this->render('_form_certificate', [
                        'model' => $certificate,
                        'work' => $model
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>