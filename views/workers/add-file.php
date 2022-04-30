<?php

/* @var $this yii\web\View */
/* @var $model app\models\WorkerFile */
/* @var $worker app\models\Worker */
/* @var $file app\models\UploadForm */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = 'Новый Файл';
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => StringHelper::truncate($worker->getCounterparty_name(), 40, '...'), 'url' => ['view', 'id' => $worker->id]];
$this->params['breadcrumbs'][] = ['label' => 'Файлы', 'url' => ['view', 'id' => $worker->id, '#' => 'file/']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form' => 'file']),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['view', 'id' => $worker->id, '#' => 'file'], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

                <div class="callout callout-danger">
                    <h5><b>ВНИМАНИЕ!</b></h5>
                    <p class="mb-1">Не рекомендуется загружать личные документы сотрудников, например - копия паспорта.</p>
                    <p>Данный раздел больше подходит для хранение внутренних документов организации, например - копия приказа о приеме на работу.</p>
                </div>

            <div class="card">
                <div class="card-body">
                    <?=$this->render('_form_file', [
                        'model' => $model,
                        'file' => $file
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>