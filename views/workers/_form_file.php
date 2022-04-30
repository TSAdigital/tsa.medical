<?php

use kartik\date\DatePicker;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WorkerFile */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $file app\models\UploadForm */
?>

<div class="counterparty-fl-form">

    <?php $form = ActiveForm::begin(['id' => 'file', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'date')->textInput(['maxlength' => true])->widget(DatePicker::classname(), [
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

        <?php
            if(empty($model->url)){
                echo $form->field($file, 'file')->fileInput();
            }
        ?>

    <?php ActiveForm::end(); ?>

</div>