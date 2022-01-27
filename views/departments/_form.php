<?php

use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Department */
/* @var $form yii\bootstrap4\ActiveForm */
?>


<div class="card-header p-2">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active error-validate" href="#base" data-toggle="tab">Основное</a></li>
        <li class="nav-item"><a class="nav-link" href="#address" data-toggle="tab">Адрес</a></li>
    </ul>
</div><!-- /.card-header -->
<div class="card-body">
    <?php $form = ActiveForm::begin(['id' => 'department']); ?>
    <div class="tab-content">
        <div class="active tab-pane" id="base">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="tab-pane" id="address">
            <?= $form->field($model, 'index')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'building')->textInput(['maxlength' => true]) ?>
        </div>
      </div>
    <?php ActiveForm::end(); ?>
</div>


