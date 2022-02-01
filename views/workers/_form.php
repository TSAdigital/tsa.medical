<?php

use app\models\Department;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="card-header p-2">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">Основное <span class="tab-1"></span></a></li>
        <li class="nav-item"><a class="nav-link" href="#tab2" data-toggle="tab">Паспорт <span class="tab-2"></span></a></li>
        <li class="nav-item"><a class="nav-link" href="#tab3" data-toggle="tab">Адрес <span class="tab-3"></span></a></li>
        <li class="nav-item"><a class="nav-link" href="#tab4" data-toggle="tab">Деятельность <span class="tab-4"></span></a></li>
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
            <div class="row">
                <div class="col-md-3"><?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'firs_name')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-3"><?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?></div>
                <div class="col-md-3">
                    <?= $form->field($model, 'birthdate')->widget(DatePicker::classname(), [
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
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'gender')->widget(Select2::classname(),
                        [
                            'data' => $model->getGenderArray(),
                            'options' => ['placeholder' => 'Выберите пол...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]); ?>
                </div>
                <div class="col-md-4"><?= $form->field($model, 'snils')->widget(MaskedInput::class, [
                        'mask' => '999-999-999 99',
                        'clientOptions' => [
                            'removeMaskOnSubmit' => true,
                        ],
                    ]) ?>
                </div>
                <div class="col-md-4"><?= $form->field($model, 'inn')->widget(MaskedInput::class, [
                        'mask' => '999999999999',
                        'clientOptions' => [
                            'removeMaskOnSubmit' => true,
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="tab2">

            <?= $form->field($model, 'passport_issued')->textInput(['maxlength' => true]) ?>

            <div class="row">
                <div class="col-md-3">

                    <?= $form->field($model, 'passport_serial')->widget(MaskedInput::class, [
                        'mask' => '99 99',
                        'clientOptions' => [
                            'removeMaskOnSubmit' => true,
                        ],
                    ]) ?>

                </div>
                <div class="col-md-3">

                    <?= $form->field($model, 'passport_number')->widget(MaskedInput::class, [
                        'mask' => '999999',
                        'clientOptions' => [
                            'removeMaskOnSubmit' => true,
                        ],
                    ]) ?>

                </div>
                <div class="col-md-3">

                    <?= $form->field($model, 'passport_department_code')->widget(MaskedInput::class, [
                        'mask' => '999-999',
                        'clientOptions' => [
                            'removeMaskOnSubmit' => true,
                        ],
                    ]) ?>

                </div>
                <div class="col-md-3">

                    <?= $form->field($model, 'passport_date')->widget(DatePicker::classname(), [
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

                </div>
            </div>

            <?= $form->field($model, 'passport_birthplace')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="tab-pane" id="tab3">

            <?= $form->field($model, 'address_index')->textInput() ?>
            <?= $form->field($model, 'address_country')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address_region')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address_district')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address_city')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address_street')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address_house')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address_body')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address_building')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address_apartment')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="tab-pane" id="tab4">

            <?= $form->field($model, 'work_position')->textInput() ?>
            <?= $form->field($model, 'work_document')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'work_document_number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'work_document_date')->textInput() ?>
            <?= $form->field($model, 'work_start')->textInput() ?>
            <?= $form->field($model, 'work_end')->textInput() ?>

        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>