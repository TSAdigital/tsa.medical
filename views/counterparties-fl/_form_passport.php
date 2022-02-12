<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Passport */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="counterparty-fl-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'passport_serial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passport_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passport_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passport_issued')->textInput() ?>

    <?= $form->field($model, 'passport_department_code')->textInput() ?>

    <?= $form->field($model, 'passport_birthplace')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>