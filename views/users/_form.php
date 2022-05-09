<?php

use app\models\AuthItem;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'user']); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->widget(MaskedInput::class, [
        'clientOptions' => [
            'alias' => 'email'
        ],
    ]) ?>
    <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'new-password']) ?>
    <?= $form->field($model, 'roles')->dropdownList(ArrayHelper::map(AuthItem::find()->where(['status' => 10, 'type' => 1])->all(), 'name', 'description'), ['prompt' => 'Выберите роль']) ?>

    <?php ActiveForm::end(); ?>

</div>
