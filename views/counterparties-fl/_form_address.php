<?php

use kartik\date\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\AddressFl */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="counterparty-fl-form">

    <?php $form = ActiveForm::begin(['id' => 'address']); ?>

        <?= $form->field($model, 'index')->widget(MaskedInput::class, [
            'mask' => '999999',
            'clientOptions' => [
                'removeMaskOnSubmit' => true,
            ],
        ]) ?>
        <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'district')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'locality')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'house')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'body')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'building')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'apartment')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>

</div>