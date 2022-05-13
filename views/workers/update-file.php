<?php

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $file app\models\WorkerFile */

use app\models\UploadForm;
use yii\helpers\Html;
use yii\helpers\StringHelper;

$button_delete = (Yii::$app->user->can('fileDelete') or Yii::$app->user->can('admin')) ?: 'disabled';

$this->title = 'Редактирование: файла ' . StringHelper::truncate($file->name, 30, '...');
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($model->getCounterparty_name(), 20, '...'), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Файлы', 'url' => ['view', 'id' => $model->id, '#' => 'file/']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($file->name, 12, '...'), 'url' => ['view-file', 'id' => $model->id, 'file' => $file->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form' => 'file']),
    'delete' => !empty($file->url) ? Html::a('<i class="far fa-trash-alt text-red"></i>Удалить файл', ['workers/delete-file', 'id' => $model->id, 'file' => $file->id], ['class' => 'btn btn-app ' . $button_delete, 'data' => [
        'confirm' => 'Удалить файл?',
        'method' => 'post',
    ]] ) : NULL,
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/view-file', 'id' => $model->id, 'file' => $file->id ], ['class' => 'btn btn-app']),
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?=$this->render('_form_file', [
                        'model' => $file,
                        'work' => $model,
                        'file' => new UploadForm(),
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>