<?php

/* @var $model app\models\Passport */
/* @var $counterparty app\models\CounterpartyFl */

use yii\helpers\Html;

$model->status === 10 ? $class = 'success' : $class = 'danger';
$button = $model->status === 10 ? Html::a('<i class="fas fa-ban text-danger"></i>', ['blocked-passport', 'id'=> $counterparty->id, 'passport' => $model->id], [
    'data' => [
        'confirm' => 'Аннулировать паспорт?',
        'method' => 'post',
    ],
]) : Html::a('<i class="far fa-check-circle text-success"></i>', ['active-passport', 'id'=> $counterparty->id, 'passport' => $model->id], [
    'data' => [
        'confirm' => 'Активировать паспорт?',
        'method' => 'post',
    ],
]);
?>
<tr>
        <td class="text-center align-middle"><?= $model->passport_serial ?></td>
        <td class="text-center align-middle"><?= $model->passport_number ?></td>
        <td class="text-center align-middle"><?= $model->passport_date ?></td>
        <td class="text-center align-middle"><?= $model->passport_department_code ?></td>
        <td class="align-middle"><?= $model->passport_issued ?></td>
        <td class="align-middle"><?= $model->passport_birthplace ?></td>
        <td class="text-center align-middle"><?= Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]) ?></td>
        <td class="text-center align-middle">
            <?= $model->status === 10 ?  Html::a('<i class="fas fa-edit text-primary"></i>', ['update-passport', 'id'=> $counterparty->id, 'passport' => $model->id]) : NULL ?>
            <?= $button ?>
        </td>
</tr>