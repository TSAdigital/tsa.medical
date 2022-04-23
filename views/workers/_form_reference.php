<?php

use app\models\Counterparty;
use app\models\ReferenceType;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Reference */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="counterparty-fl-form">

    <?php $form = ActiveForm::begin(['id' => 'reference']); ?>

        <?= $form->field($model, 'reference_type_id')->widget(Select2::classname(),
            [
                'data' => ArrayHelper::map(ReferenceType::find()->where(['status' => 10])->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Выберите вид справки...'],
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
                'endDate' => "0d"
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

    <?php ActiveForm::end(); ?>

</div>