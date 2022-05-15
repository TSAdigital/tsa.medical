<?php

/* @var $model app\models\Passport */
/* @var $counterparty app\models\CounterpartyFl */

use yii\helpers\Html;

$model->status === 10 ? $class = 'success' : $class = 'danger';
?>
<tr>
    <td class="text-center align-middle"><?= Yii::$app->formatter->asPassportSerial($model->passport_serial) ?></td>
    <td class="text-center align-middle"><?= $model->passport_number ?></td>
    <td class="text-center align-middle"><?= $model->passport_date ?></td>
    <td class="text-center align-middle"><?= Yii::$app->formatter->asPassportDepartmentCode($model->passport_department_code) ?></td>
    <td class="align-middle"><?= $model->passport_issued ?></td>
    <td class="align-middle"><?= $model->passport_birthplace ?></td>
    <td class="text-center align-middle"><?= Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]) ?></td>
    <td class="text-center align-middle">
        <?= (Yii::$app->user->can('counterpartyFlPassportView') or Yii::$app->user->can('admin')) ? Html::a('<i class="fas fa-sign-in-alt text-muted"></i>', ['view-passport', 'id'=> $counterparty->id, 'passport' => $model->id], ['class' => 'btn m-0 p-0']) : Html::a('<i class="fas fa-sign-in-alt text-muted"></i>', ['view-passport', 'id'=> $counterparty->id, 'passport' => $model->id], ['class' => 'btn disabled m-0 p-0']) ?>
    </td>
</tr>