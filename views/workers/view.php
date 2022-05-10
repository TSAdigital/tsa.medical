<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $age app\controllers\CounterpartiesFlController */
/* @var $work app\models\Work */
/* @var $certificate app\models\Certificate */
/* @var $file app\models\WorkerFile */
/* @var $reference app\models\Reference */
/* @var $vaccination app\models\Vaccination */
/* @var $work_time app\controllers\CounterpartiesFlController */

$this->title = StringHelper::truncate($model->getCounterparty_name(), 45, '...');
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$disabled_update = (Yii::$app->user->can('workerUpdate') or Yii::$app->user->can('admin')) ?: 'disabled';
$disabled_block = (Yii::$app->user->can('workerBlocked') or Yii::$app->user->can('admin')) ?: 'disabled';
$disabled_active = (Yii::$app->user->can('workerActive') or Yii::$app->user->can('admin')) ?: 'disabled';
$disabled_history = (Yii::$app->user->can('workerHistory') or Yii::$app->user->can('admin')) ?: 'disabled';
$this->params['buttons'] = [
    'update' => $model->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-app ' . $disabled_update]) : false,
    'block' => $model->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked', 'id' => $model->id], [
        'class' => 'btn btn-app ' . $disabled_block,
        'data' => [
            'confirm' => 'Аннулировать сотрудника?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $model->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active', 'id' => $model->id], [
        'class' => 'btn btn-app ' . $disabled_active,
        'data' => [
            'confirm' => 'Активировать сотрудника?',
            'method' => 'post',
        ],
    ]) : false,
    'history' => Html::a('<i class="fas fa-history text-info"></i>История', ['history', 'id' => $model->id], ['class' => 'btn btn-app ' . $disabled_history]),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['workers/index'], ['class' => 'btn btn-app'])
];
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills" id="myTab">
                        <li class="nav-item"><a class="nav-link active" href="#base" data-toggle="tab">Основное</a></li>
                        <li class="nav-item"><a class="nav-link" href="#work" data-toggle="tab">Деятельность</a></li>
                        <li class="nav-item"><a class="nav-link" href="#certificate" data-toggle="tab">Сертификаты</a></li>
                        <li class="nav-item"><a class="nav-link" href="#reference" data-toggle="tab">Справки</a></li>
                        <li class="nav-item"><a class="nav-link" href="#vaccination" data-toggle="tab">Вакцинация</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact" data-toggle="tab">Контакты</a></li>
                        <li class="nav-item"><a class="nav-link" href="#file" data-toggle="tab">Файлы</a></li>
                    </ul>
                </div>
                <div class="card-body pb-1">
                    <div class="tab-content">
                        <div class="active tab-pane" id="base">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => [
                                    'class' => 'table table-bordered table-striped',
                                ],
                                'attributes' => [
                                    [
                                        'attribute' => 'category',
                                        'value' => $model->getCategoryName(),
                                    ],
                                    [
                                        'attribute' => 'counterparty_name',
                                        'captionOptions' => ['width' => '220px'],
                                        'value' => Html::a($model->getCounterparty_name(), ['counterparties-fl/view', 'id' => $model->counterparty_id], ['target'=>'_blank']),
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'age',
                                        'value' => Yii::$app->inflection->textizeTimeRange(new DateInterval('P'.$age.'Y')),
                                    ],
                                    [
                                        'attribute' => 'date_of_employment',
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'date_of_dismissal',
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'work_time',
                                        'visible' => !empty($work_time),
                                        'value' => $work_time != NULL ? Yii::$app->inflection->textizeTimeRange(new DateInterval('P'.$work_time.'D')) : NULL,
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'value' => $model->getStatusName(),
                                    ],
                                    'created_at:datetime',
                                    'updated_at:datetime',
                                ],
                            ]) ?>
                        </div>
                        <div class="tab-pane" id="work">
                            <div class="row">
                                <div class="table-responsive">

                                    <?php
                                    $button_add_passport =  $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-work', 'id' => $model->id]) : null;
                                    $template = '
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                 <tr>
                                                    <th scope="col" class="align-middle">Подразделение</th>
                                                    <th scope="col" class="align-middle">Занятость</th>
                                                    <th scope="col" class="align-middle">Должность</th>
                                                    <th scope="col" class="text-center align-middle">Ставка</th>
                                                    <th scope="col" class="text-center align-middle">Статус</th>
                                                    <th scope="col" class="text-center align-middle">'. $button_add_passport .'</th>
                                                </tr>      
                                                </thead>
                                                <tbody>
                                                    {items}
                                                </tbody>
                                            </table>
                                            {pager}
                                        ';
                                    ?>

                                    <?= ListView::widget([
                                        'dataProvider' => $work,
                                        'layout' => $template,
                                        'emptyText' => $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-work', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block']) : 'Невозможно добавить новую запись.',
                                        'emptyTextOptions' => ['class' => 'empty mb-3'],
                                        'itemOptions' => [
                                            'tag' => false,
                                        ],
                                        'viewParams'=> ['worker' => $model],
                                        'itemView' => '_list_work',
                                        'pager' => [
                                            'class' => 'yii\bootstrap4\LinkPager',
                                        ],
                                    ]); ?>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="certificate">
                            <?php
                            $button_add_certificate =  $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-certificate', 'id' => $model->id]) : null;
                            $template = '
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                 <tr>
                                                    <th scope="col" class="align-middle">Кем выдан</th>
                                                    <th scope="col" class="align-middle">Специальность</th>
                                                    <th scope="col" class="text-center align-middle">Дата выдачи</th>
                                                    <th scope="col" class="text-center align-middle">Срок действия</th>
                                                    <th scope="col" class="text-center align-middle">Статус</th>
                                                    <th scope="col" class="text-center align-middle">'. $button_add_certificate .'</th>
                                                </tr>      
                                                </thead>
                                                <tbody>
                                                    {items}
                                                </tbody>
                                            </table>
                                            {pager}
                                        ';
                            ?>

                            <?= ListView::widget([
                                'dataProvider' => $certificate,
                                'layout' => $template,
                                'emptyText' => $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-certificate', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block']) : 'Невозможно добавить новую запись.',
                                'emptyTextOptions' => ['class' => 'empty mb-3'],
                                'itemOptions' => [
                                    'tag' => false,
                                ],
                                'viewParams'=> ['worker' => $model],
                                'itemView' => '_list_certificate',
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',
                                ],
                            ]); ?>
                        </div>
                        <div class="tab-pane" id="reference">
                            <?php
                            $button_add_reference =  $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-reference', 'id' => $model->id]) : null;
                            $template = '
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                 <tr>
                                                    <th scope="col" class="align-middle">Наименование</th>
                                                    <th scope="col" class="align-middle">Кем выдана</th>
                                                    <th scope="col" class="text-center align-middle">Дата вакцинации</th>
                                                    <th scope="col" class="text-center align-middle">Срок действия</th>
                                                    <th scope="col" class="text-center align-middle">Статус</th>
                                                    <th scope="col" class="text-center align-middle">'. $button_add_reference .'</th>
                                                </tr>      
                                                </thead>
                                                <tbody>
                                                    {items}
                                                </tbody>
                                            </table>
                                            {pager}
                                        ';
                            ?>

                            <?= ListView::widget([
                                'dataProvider' => $reference,
                                'layout' => $template,
                                'emptyText' => $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-reference', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block']) : 'Невозможно добавить новую запись.',
                                'emptyTextOptions' => ['class' => 'empty mb-3'],
                                'itemOptions' => [
                                    'tag' => false,
                                ],
                                'viewParams'=> ['worker' => $model],
                                'itemView' => '_list_reference',
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',
                                ],
                            ]); ?>

                        </div>
                        <div class="tab-pane" id="vaccination">
                            <?php
                            $button_add_vaccination =  $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>', ['create-vaccination', 'id' => $model->id]) : null;
                            $template = '
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                 <tr>
                                                    <th scope="col" class="align-middle">Наименование</th>
                                                    <th scope="col" class="align-middle">Вакцинация проходила в</th>
                                                    <th scope="col" class="text-center align-middle">Дата выдачи</th>
                                                    <th scope="col" class="text-center align-middle">Срок действия</th>
                                                    <th scope="col" class="text-center align-middle">Статус</th>
                                                    <th scope="col" class="text-center align-middle">'. $button_add_vaccination .'</th>
                                                </tr>      
                                                </thead>
                                                <tbody>
                                                    {items}
                                                </tbody>
                                            </table>
                                            {pager}
                                        ';
                            ?>

                            <?= ListView::widget([
                                'dataProvider' => $vaccination,
                                'layout' => $template,
                                'emptyText' => $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create-vaccination', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block']) : 'Невозможно добавить новую запись.',
                                'emptyTextOptions' => ['class' => 'empty mb-3'],
                                'itemOptions' => [
                                    'tag' => false,
                                ],
                                'viewParams'=> ['worker' => $model],
                                'itemView' => '_list_vaccination',
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',
                                ],
                            ]); ?>
                        </div>
                        <div class="tab-pane" id="contact">
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => [
                                    'class' => 'table table-bordered table-striped',
                                ],
                                'attributes' => [
                                    'phone:phone',
                                    [
                                        'attribute' => 'extension_phone',
                                        'captionOptions' => ['width' => '240px'],
                                    ],
                                    'email:email',
                                ],
                            ]) ?>
                        </div>
                        <div class="tab-pane" id="file">
                            <?php
                            $button_add_file =  $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>', ['add-file', 'id' => $model->id]) : null;
                            $template = '
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                 <tr>
                                                    <th scope="col" class="align-middle">Наименование</th>
                                                    <th scope="col" class="text-center align-middle">Дата</th>
                                                    <th scope="col" class="text-center align-middle">Статус</th>
                                                    <th scope="col" class="text-center align-middle">'. $button_add_file .'</th>
                                                </tr>      
                                                </thead>
                                                <tbody>
                                                    {items}
                                                </tbody>
                                            </table>
                                            {pager}
                                        ';
                            ?>

                            <?= ListView::widget([
                                'dataProvider' => $file,
                                'layout' => $template,
                                'emptyText' => $model->status == 10 ? Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['add-file', 'id' => $model->id], ['class' => 'btn btn-app mx-auto d-block']) : 'Невозможно добавить новую запись.',
                                'emptyTextOptions' => ['class' => 'empty mb-3'],
                                'itemOptions' => [
                                    'tag' => false,
                                ],
                                'viewParams'=> ['worker' => $model],
                                'itemView' => '_list_file',
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>