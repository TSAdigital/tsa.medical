<?php

/* @var $model app\models\AddressFl */
/* @var $counterparty app\models\CounterpartyFl */

use yii\helpers\Html;

$model->status === 10 ? $class = 'success' : $class = 'danger';
$button = $model->status === 10 ? Html::a('<i class="fas fa-ban text-danger"></i>', ['blocked-address', 'id'=> $counterparty->id, 'address' => $model->id], [
    'data' => [
        'confirm' => 'Аннулировать адрес?',
        'method' => 'post',
    ],
]) : Html::a('<i class="far fa-check-circle text-success"></i>', ['active-address', 'id'=> $counterparty->id, 'address' => $model->id], [
    'data' => [
        'confirm' => 'Активировать адрес?',
        'method' => 'post',
    ],
]);
?>
<tr>
    <td class="text-center align-middle"><?= $model->getAddressName() ?></td>
    <td class="text-center align-middle"><?= $model->index ?></td>
    <td class="text-center align-middle"><?= $model->country ?></td>
    <td class="align-middle"><?= $model->region ?></td>
    <td class="align-middle d-none"><?= $model->district ?></td>
    <td class="align-middle"><?= $model->city ?></td>
    <td class="align-middle d-none"><?= $model->locality ?></td>
    <td class="align-middle"><?= $model->street ?></td>
    <td class="text-center align-middle"><?= $model->house ?></td>
    <td class="text-center align-middle"><?= $model->body ?></td>
    <td class="text-center align-middle d-none"><?= $model->building ?></td>
    <td class="text-center align-middle"><?= $model->apartment ?></td>
    <td class="text-center align-middle"><?= Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]) ?></td>
    <td class="text-center align-middle">
        <?= $model->status === 10 ?  Html::a('<i class="fas fa-edit text-primary"></i>', ['update-address', 'id'=> $counterparty->id, 'address' => $model->id]) : NULL ?>
        <?= $button ?>
    </td>
</tr>
