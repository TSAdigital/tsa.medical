<?php

use app\models\Department;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="card-header p-2">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">Основное <span class="tab-1"></span></a></li>
        <li class="nav-item"><a class="nav-link address" href="#tab2" data-toggle="tab">Паспорт <span class="tab-2"></span></a></li>
    </ul>
</div>
<div class="card-body">
    <?php $form = ActiveForm::begin(['id' => 'position']); ?>
    <div class="tab-content">
        <div class="active tab-pane" id="tab1">
            <?= $form->field($model, 'department')->widget(Select2::classname(),
                [
                    'data' => ArrayHelper::map(Department::find()->where(['status' => 10])->all(),'id','name'),
                    'options' => ['placeholder' => 'Выберите подразделение...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>

            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'firs_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'birthdate') ->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Ввод даты ...'],
                'value'=> 'dd.mm.yyyy',
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'autoclose'=>true,
                    'todayBtn'=>true,
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

            <?= $form->field($model, 'snils')->textInput() ?>

            <?= $form->field($model, 'inn')->textInput() ?>
        </div>
        <div class="tab-pane" id="tab2">

        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>