<?php

use app\models\CounterpartyFl;
use app\models\Department;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Worker */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="card-header p-2">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">Основное <span class="tab-1"></span></a></li>
        <li class="nav-item"><a class="nav-link" href="#tab2" data-toggle="tab">Полис <span class="tab-2"></span></a></li>
    </ul>
</div>
<div class="card-body">
    <?php $form = ActiveForm::begin(['id' => 'position']); ?>
    <div class="tab-content">
        <div class="active tab-pane" id="tab1">

            <?= $form->field($model, 'counterparty_id')->widget(Select2::classname(),
                [
                    'data' => ArrayHelper::map(CounterpartyFl::find()->where(['status' => 10])->all(), 'id', function($data){return $data->getFullName();}),
                    'options' => ['placeholder' => 'Выберите контрагента...'],
                    'pluginOptions' => [
                        'allowClear' => true
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

            <?= $form->field($model, 'document_date')->widget(DatePicker::classname(), [
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
        <div class="tab-pane" id="tab2">



        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

