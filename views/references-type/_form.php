<?php

use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ReferenceType */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="reference-type-form">

    <?php $form = ActiveForm::begin(['id' => 'references-type']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>

</div>
