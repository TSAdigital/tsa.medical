<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Department */

$this->title = 'Новое Подразделение';
$this->params['breadcrumbs'][] = ['label' => 'Подразделения', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = [
    'save' => Html::submitButton('<i class="far fa-save text-green"></i>Сохранить', ['class' => 'btn btn-app', 'form'=>"department"]),
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['departments/index'], ['class' => 'btn btn-app'])
];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <?= $this->render('_form', [
                    'model' => $model
                ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>