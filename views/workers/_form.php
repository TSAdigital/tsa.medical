<?php

use app\models\CounterpartyFl;
use app\models\Department;
use app\models\Position;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="card-header p-2">
    <ul class="nav nav-pills nav-pos">
        <li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">Основное <span class="tab-1"></span></a></li>
        <li class="nav-item"><a class="nav-link" href="#tab2" data-toggle="tab">Деятельность <span class="tab-2"></span></a></li>
        <li class="nav-item"><a class="nav-link" href="#tab3" data-toggle="tab">Контакты <span class="tab-3"></span></a></li>
    </ul>
</div>
<div class="card-body">
    <?php $form = ActiveForm::begin(['id' => 'workers']); ?>
    <div class="tab-content">
        <div class="active tab-pane" id="tab1">

            <?= $form->field($model, 'counterparty_id')->widget(Select2::classname(),
                [
                    'data' => ArrayHelper::map(CounterpartyFl::find()->where(['id' => $model->counterparty_id])->all(), 'id', function($data){return $data->last_name .' ' . $data->first_name .' ' . $data->middle_name;}),
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
                    'depends' => ['worker-department_id'],
                    'initialize' => (bool)$model->department_id,
                    'loadingText' => 'загрузка',
                    'url' => Url::to(['/workers/subcat'])
                ],
            ]);
            ?>
        </div>
        <div class="tab-pane" id="tab2">

            <?= $form->field($model, 'position_id')->widget(Select2::classname(),
                [
                    'data' => ArrayHelper::map(Position::find()->where(['status' => 10])->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Выберите должность...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>

        </div>
        <div class="tab-pane" id="tab3">

            <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                'mask' => '9(999)999 99 99',
                'clientOptions' => [
                    'removeMaskOnSubmit' => true,
                ],
            ]) ?>

            <?= $form->field($model, 'extension_phone')->textInput() ?>

            <?= $form->field($model, 'email')->widget(MaskedInput::class, [
                'clientOptions' => [
                    'alias' => 'email'
                ],
            ]) ?>

        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

