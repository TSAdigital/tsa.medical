<?php

use kartik\date\DatePicker;
use yii\bootstrap4\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Passport */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="counterparty-fl-form">

    <?php $form = ActiveForm::begin(['id' => 'passport']); ?>

    <?= $form->field($model, 'passport_serial')->widget(MaskedInput::class, [
        'mask' => '99 99',
        'clientOptions' => [
            'removeMaskOnSubmit' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'passport_number')->widget(MaskedInput::class, [
        'mask' => '999999',
        'clientOptions' => [
            'removeMaskOnSubmit' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'passport_date')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Ввод даты ...'],
        'value' => 'dd.mm.yyyy',
        'pluginOptions' => [
            'format' => 'dd.mm.yyyy',
            'autoclose' => true,
            'todayBtn' => true,
            'todayHighlight' => true,
            'endDate' => "0d"
        ]
    ]); ?>

    <?= $form->field($model, 'passport_issued')->textInput() ?>

    <?= $form->field($model, 'passport_department_code')->widget(MaskedInput::class, [
        'mask' => '999-999',
        'clientOptions' => [
            'removeMaskOnSubmit' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'passport_birthplace')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>

</div>