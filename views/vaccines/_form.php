<?php

use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Vaccine */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="vaccine-form">

    <?php $form = ActiveForm::begin(['id' => 'vaccine']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>

</div>
