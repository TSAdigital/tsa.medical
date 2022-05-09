<?php

use app\models\Counterparty;
use app\models\Vaccine;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Vaccination */
/* @var $form yii\bootstrap4\ActiveForm */

$template = [
    'labelOptions'=>['class'=>'col-lg-3'],
    'template' => '{label} <div class="col-lg-offset-9 col-lg-9 checkbox">{input}{error}{hint}</div>',
];
?>

<div class="counterparty-fl-form">

    <?php $form = ActiveForm::begin(['id' => 'vaccination']); ?>

        <?= $form->field($model, 'vaccine_id')->widget(Select2::classname(),
            [
                'data' => ArrayHelper::map(Vaccine::find()->where(['status' => 10])->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите вид вакцины...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        ?>

        <?= $form->field($model, 'counterparty_id')->widget(Select2::classname(),
            [
                'data' => ArrayHelper::map(Counterparty::find()->where(['id' => $model->counterparty_id])->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите контрагента...'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Ждем результатов...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/workers/counterparty-list']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }')
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(counterparty_id) { return counterparty_id.text; }'),
                    'templateSelection' => new JsExpression('function (counterparty_id) { return counterparty_id.text; }'),
                ],
            ]);
        ?>



        <?= $form->field($model, 'start_date')->textInput(['maxlength' => true])->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Ввод даты ...'],
            'value' => 'dd.mm.yyyy',
            'pluginOptions' => [
                'format' => 'dd.mm.yyyy',
                'autoclose' => true,
                'todayBtn' => true,
                'todayHighlight' => true,
            ]
        ]); ?>

        <?= $form->field($model, 'end_date')->textInput(['maxlength' => true])->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Ввод даты ...'],
            'value' => 'dd.mm.yyyy',
            'pluginOptions' => [
                'format' => 'dd.mm.yyyy',
                'autoclose' => true,
                'todayBtn' => true,
                'todayHighlight' => true,
            ]
        ]); ?>

        <?= $form->field($model, 'revaccination')->checkbox([
            'value' => '10',
        ]); ?>

    <?php ActiveForm::end(); ?>

</div>