<?php

use app\models\Position;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Counterparty */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="card-header p-2">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">Основное <span class="tab-1"></span></a></li>
        <li class="nav-item"><a class="nav-link address" href="#tab2" data-toggle="tab">Руководитель <span class="tab-2"></span></a></li>
    </ul>
</div>
<div class="card-body">
    <?php $form = ActiveForm::begin(['id' => 'counterparty']); ?>
    <div class="tab-content">
        <div class="active tab-pane" id="tab1">

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'inn')->widget(MaskedInput::class, [
                'mask' => '9{10,12}',
                'clientOptions' => [
                    'removeMaskOnSubmit' => true,
                ],
            ]) ?>
            <?= $form->field($model, 'kpp')->widget(MaskedInput::class, [
                'mask' => '999999999',
                'clientOptions' => [
                    'removeMaskOnSubmit' => true,
                ],
            ]) ?>
            <?= $form->field($model, 'ogrn')->widget(MaskedInput::class, [
                'mask' => '9999999999999',
                'clientOptions' => [
                    'removeMaskOnSubmit' => true,
                ],
            ]) ?>
            <?= $form->field($model, 'okpo')->widget(MaskedInput::class, [
                'mask' => '9{8,10}',
                'clientOptions' => [
                    'removeMaskOnSubmit' => true,
                ],
            ]) ?>
            <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                'mask' => '9(999)999 99 99',
                'clientOptions' => [
                    'removeMaskOnSubmit' => true,
                ],
            ]) ?>
            <?= $form->field($model, 'email')->widget(MaskedInput::class, [
                'clientOptions' => [
                    'alias' => 'email'
                ],
            ]) ?>
            <?= $form->field($model, 'web_site')->widget(MaskedInput::class, [
                'clientOptions' => [
                    'alias' => 'url',
                ],
            ]) ?>

        </div>

        <div class="tab-pane" id="tab2">

            <?= $form->field($model, 'director_last_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'director_firs_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'director_middle_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'director_position')->widget(Select2::classname(),
                [
                    'data' => ArrayHelper::map(Position::find()->where(['status' => 10])->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Выберите должность...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
            <?= $form->field($model, 'director_document')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
