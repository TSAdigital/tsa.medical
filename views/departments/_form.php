<?php

use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Department */
/* @var $form yii\bootstrap4\ActiveForm */
?>


<div class="department-form">

    <?php $form = ActiveForm::begin(['id' => 'department']); ?>

            <?= $form->field($model, 'name')->textInput([
                'maxlength' => true,
                ]) ?>

    <?php ActiveForm::end(); ?>
</div>


