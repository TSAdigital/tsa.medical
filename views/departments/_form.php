<?php

use yii\bootstrap4\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Department */
/* @var $form yii\bootstrap4\ActiveForm */
?>


<div class="card-header p-2">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">Основное <span class="tab-1"></span></a></li>
        <li class="nav-item"><a class="nav-link address" href="#tab2" data-toggle="tab">Адрес <span class="tab-2"></span></a></li>
    </ul>
</div>
<div class="card-body">
    <?php $form = ActiveForm::begin(['id' => 'department']); ?>
    <div class="tab-content">
        <div class="active tab-pane" id="tab1">
            <?= $form->field($model, 'name')->textInput([
                'maxlength' => true,
                ]) ?>
        </div>
        <div class="tab-pane" id="tab2">
            <div class="row">
                <div class="col-md-3"><?= $form->field($model, 'index')->widget(MaskedInput::class, [
                        'mask' => '999999',
                        'clientOptions' => [
                            'removeMaskOnSubmit' => true,
                        ],
                    ]) ?>
                </div>
                <div class="col-md-3"><?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?></div>
            </div>
            <div class="row">
                <div class="col-md-4"><?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-4"><?= $form->field($model, 'locality')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-4"><?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?></div>
            </div>
            <div class="row">
                <div class="col-md-3"><?= $form->field($model, 'house')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'body')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'building')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'office')->textInput(['maxlength' => true]) ?></div>
            </div>
        </div>
      </div>
    <?php ActiveForm::end(); ?>
</div>


