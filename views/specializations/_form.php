<?php

use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Specialization */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="specialization-form">

    <?php $form = ActiveForm::begin(['id' => 'specialization']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>

</div>
