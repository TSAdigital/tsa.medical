<?php

/* @var $model app\models\AddressFl */
/* @var $counterparty app\models\CounterpartyFl */

use yii\helpers\Html;

$model->status === 10 ? $class = 'success' : $class = 'danger';
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
    <td class="text-center align-middle d-none"><?= $model->body ?></td>
    <td class="text-center align-middle d-none"><?= $model->building ?></td>
    <td class="text-center align-middle"><?= $model->apartment ?></td>
    <td class="text-center align-middle"><?= Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]) ?></td>
    <td class="text-center align-middle">
        <?= Html::a('<i class="fas fa-sign-in-alt text-muted"></i>', ['view-address', 'id'=> $counterparty->id, 'address' => $model->id]) ?>
    </td>
</tr>
