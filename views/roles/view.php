<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */
/* @var $roleName app\models\AuthItem */
/* @var $permissions app\models\AuthItemChild */

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
    'update' => $model->status == 10 ? Html::a('<i class="fas fa-edit text-primary"></i>Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-app']) : false,
    'block' => $model->status == 10 ? Html::a('<i class="fas fa-ban text-danger"></i>Аннулировать', ['blocked', 'id' => $model->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Аннулировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'active' => $model->status == 9 ? Html::a('<i class="far fa-check-circle text-success"></i>Активировать', ['active', 'id' => $model->id], [
        'class' => 'btn btn-app',
        'data' => [
            'confirm' => 'Активировать запись?',
            'method' => 'post',
        ],
    ]) : false,
    'history' => Html::a('<i class="fas fa-history text-info"></i>История', ['history', 'id' => $model->id], ['class' => 'btn btn-app']),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['index'], ['class' => 'btn btn-app'])
];
?>



<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills" id="myTab">
                        <li class="nav-item"><a class="nav-link active" href="#base" data-toggle="tab">Основное</a></li>
                        <li class="nav-item"><a class="nav-link" href="#permissions" data-toggle="tab">Разрешения</a></li>
                    </ul>
                </div>
                <div class="card-body pb-1">
                    <div class="tab-content">
                        <div class="active tab-pane" id="base">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    [
                                        'attribute' => 'description',
                                        'captionOptions' => ['width' => '200px'],
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
                        <div class="tab-pane" id="permissions">
                            <?php $form = ActiveForm::begin(); ?>
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Раздел</th>
                                    <th scope="col" class="text-center">Меню</th>
                                    <th scope="col" class="text-center">Список</th>
                                    <th scope="col" class="text-center">Просмотр</th>
                                    <th scope="col" class="text-center">Редактировать</th>
                                    <th scope="col" class="text-center">Аннулировать</th>
                                    <th scope="col" class="text-center">Активировать</th>
                                    <th scope="col" class="text-center">История</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row" class="align-middle">Должности</th>
                                    <td class="text-center align-middle"><?= $form->field($permissions, 'viewPositionMenu', ['options' => ['tag' => false]])->input('checkbox', ['class'=>'', 'checked ' => $permissions->checked('viewPositionMenu', $roleName)])->label(false) ?></td>
                                    <td class="text-center align-middle"><?= $form->field($permissions, 'viewPositionIndex', ['options' => ['tag' => false]])->input('checkbox', ['class'=>'', 'checked ' => $permissions->checked('viewPositionIndex', $roleName)])->label(false) ?></td>
                                    <td class="text-center align-middle"><?= $form->field($permissions, 'viewPositionView', ['options' => ['tag' => false]])->input('checkbox', ['class'=>'', 'checked ' => $permissions->checked('viewPositionView', $roleName)])->label(false) ?></td>
                                    <td class="text-center align-middle"><?= $form->field($permissions, 'viewPositionUpdate', ['options' => ['tag' => false]])->input('checkbox', ['class'=>'', 'checked ' => $permissions->checked('viewPositionUpdate', $roleName)])->label(false) ?></td>
                                    <td class="text-center align-middle"><?= $form->field($permissions, 'viewPositionActive', ['options' => ['tag' => false]])->input('checkbox', ['class'=>'', 'checked ' => $permissions->checked('viewPositionActive', $roleName)])->label(false) ?></td>
                                    <td class="text-center align-middle"><?= $form->field($permissions, 'viewPositionBlocked', ['options' => ['tag' => false]])->input('checkbox', ['class'=>'', 'checked ' => $permissions->checked('viewPositionBlocked', $roleName)])->label(false) ?></td>
                                    <td class="text-center align-middle"></td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <?= Html::submitButton('<i class="far fa-save text-success"></i>Сохранить', ['class' => 'btn btn-app mx-auto d-block']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>