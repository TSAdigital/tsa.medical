<?php

use app\models\Department;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Division */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="division-form">

    <?php $form = ActiveForm::begin(['id' => 'division']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'department')->widget(Select2::classname(),
        [
            'data' => ArrayHelper::map(Department::find()->where(['status' => 10])->all(),'id','name'),
            'options' => ['placeholder' => 'Выберите подразделение...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?php ActiveForm::end(); ?>

</div>
