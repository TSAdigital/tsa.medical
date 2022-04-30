<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $file app\models\WorkerFile */

$this->title = StringHelper::truncate($model->getCounterparty_name(), 50, '...');
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->getCounterparty_name(), 30, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Файлы', 'url' => ['view', 'id' => $model->id, '#' => 'file/']];
$this->params['breadcrumbs'][] = StringHelper::truncate($file->name, 10, '...');
$this->params['buttons'] = [
    'downloads' => ($file->status == 10 and file_exists($file->url) and !is_dir($file->url)) ? Html::a('<i class="fas fa-download text-success"></i>Скачать файл', ['workers/download', 'id'=> $model->id, 'file' => $file->id], ['class' => 'btn btn-app']) : false,
    'update' => $file->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update-file', 'id' => $model->id, 'file' => $file->id], ['class' => 'btn btn-app']) : false,
    'block' => $file->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked-file', 'id' => $model->id, 'file' => $file->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Аннулировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $file->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active-file', 'id' => $model->id, 'file' => $file->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Активировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/view', 'id' => $model->id, '#' => 'file/'], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <?= DetailView::widget([
                        'model' => $file,
                        'attributes' => [
                            [
                                'attribute' => 'name',
                                'captionOptions' => ['width' => '230px'],
                            ],
                            'date',

                            [
                                'attribute' => 'status',
                                'value' => $file->getStatusName(),
                            ],
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>