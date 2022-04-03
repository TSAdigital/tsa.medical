<?php

use app\models\Department;
use app\models\Position;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Work */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="counterparty-fl-form">

    <?php $form = ActiveForm::begin(['id' => 'work']); ?>

        <?= $form->field($model, 'department_id')->widget(Select2::classname(),
            [
                'data' => ArrayHelper::map(Department::find()->where(['status' => 10])->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите подразделение...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        ?>

        <?= $form->field($model, 'division_id')->widget(DepDrop::classname(), [
            'type' => DepDrop::TYPE_SELECT2,
            'options' => ['placeholder' => 'Выберите отделение ...'],
            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
            'pluginOptions' => [
                'depends' => ['work-department_id'],
                'initialize' => (bool)$model->department_id,
                'loadingText' => 'загрузка',
                'url' => Url::to(['/workers/subcat'])
            ],
        ]);
        ?>

        <?= $form->field($model, 'busyness')->widget(Select2::classname(),
            [
                'data' => $model->getEmploymentArray(),
                'options' => ['placeholder' => 'Выберите занятость...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        ?>

        <?= $form->field($model, 'work_start_date')->textInput(['maxlength' => true])->widget(DatePicker::classname(), [
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

        <?= $form->field($model, 'position_id')->widget(Select2::classname(),
            [
                'data' => ArrayHelper::map(Position::find()->where(['status' => 10])->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите должность...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        ?>

        <?= $form->field($model, 'bet')->widget(MaskedInput::class, [
            'mask' => '9.99',
        ]) ?>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'document')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'document_number')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'document_date')->textInput(['maxlength' => true])->widget(DatePicker::classname(), [
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
            </div>
        </div>

        <?= $form->field($model, 'work_end_date')->textInput(['maxlength' => true])->widget(DatePicker::classname(), [
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

    <?php ActiveForm::end(); ?>

</div>