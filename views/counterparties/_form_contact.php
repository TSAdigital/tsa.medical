<?php

use app\models\Position;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Contact */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="counterparty-fl-form">

    <?php $form = ActiveForm::begin(['id' => 'contact']); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'position_id')->widget(Select2::classname(),
        [
            'data' => ArrayHelper::map(Position::find()->where(['status' => 10])->all(), 'id', 'name'),
            'options' => ['placeholder' => 'Выберите должность...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
        'mask' => '9(999)999 99 99',
        'clientOptions' => [
            'removeMaskOnSubmit' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'phone_extension')->textInput() ?>

    <?= $form->field($model, 'email')->widget(MaskedInput::class, [
        'clientOptions' => [
            'alias' => 'email'
        ],
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>