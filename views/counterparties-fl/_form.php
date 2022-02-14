<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\CounterpartyFl */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="counterparty-fl-form">

    <?php $form = ActiveForm::begin(['id' => 'counterparty-fl']); ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'firs_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birthdate')->widget(DatePicker::classname(), [
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

    <?= $form->field($model, 'gender')->widget(Select2::classname(),
        [
            'data' => $model->getGenderArray(),
            'options' => ['placeholder' => 'Выберите пол...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

    <?= $form->field($model, 'snils')->widget(MaskedInput::class, [
        'mask' => '999-999-999 99',
        'clientOptions' => [
            'removeMaskOnSubmit' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'inn')->widget(MaskedInput::class, [
        'mask' => '999999999999',
        'clientOptions' => [
            'removeMaskOnSubmit' => true,
        ],
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>
