<?php

use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Position */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="card-header p-2">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">Основное <span class="tab-1"></span></a></li>
        <li class="nav-item"><a class="nav-link address" href="#tab2" data-toggle="tab">Склонение <span class="tab-2"></span></a></li>
    </ul>
</div>
<div class="card-body">
    <?php $form = ActiveForm::begin(['id' => 'position']); ?>
    <div class="tab-content">
        <div class="active tab-pane" id="tab1">
            <?= $form->field($model, 'name')->textInput([
                'maxlength' => true,
            ]) ?>
        </div>
        <div class="tab-pane" id="tab2">
            <?= $form->field($model, 'name_i')->textInput(['maxlength' => true, 'placeholder' => "кто, что? - Генеральный директор"]) ?>
            <?= $form->field($model, 'name_r')->textInput(['maxlength' => true, 'placeholder' => "кого, чего? - Генерального директора"]) ?>
            <?= $form->field($model, 'name_d')->textInput(['maxlength' => true, 'placeholder' => "кому, чему? - Генеральному директору"]) ?>
            <?= $form->field($model, 'name_v')->textInput(['maxlength' => true, 'placeholder' => "кого, что? - Генерального директора"]) ?>
            <?= $form->field($model, 'name_t')->textInput(['maxlength' => true, 'placeholder' => "кем, чем? - Генеральным директором"]) ?>
            <?= $form->field($model, 'name_p')->textInput(['maxlength' => true, 'placeholder' => "о ком, о чем? - о Генеральном директоре"]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
