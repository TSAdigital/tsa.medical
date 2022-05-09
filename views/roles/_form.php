<?php

use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(['id' => 'role']); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>

</div>
