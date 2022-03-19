<?php

/* @var $model app\models\Contact */
/* @var $counterparty app\models\Counterparty */

use yii\helpers\Html;

$model->status === 10 ? $class = 'success' : $class = 'danger';
$button = $model->status === 10 ? Html::a('<i class="fas fa-ban text-danger"></i>', ['blocked-contact', 'id'=> $counterparty->id, 'contact' => $model->id], [
    'data' => [
        'confirm' => 'Аннулировать контакт?',
        'method' => 'post',
    ],
]) : Html::a('<i class="far fa-check-circle text-success"></i>', ['active-contact', 'id'=> $counterparty->id, 'contact' => $model->id], [
    'data' => [
        'confirm' => 'Активировать контакт?',
        'method' => 'post',
    ],
]);
?>
<tr>
        <td class="align-middle"><?= $model->name ?></td>
        <td class="align-middle"><?= $model->getPositionName() ?></td>
        <td class="align-middle"><?= Yii::$app->formatter->asPhone($model->phone) ?></td>
        <td class="align-middle"><?= $model->phone_extension ?></td>
        <td class="align-middle"><?= Yii::$app->formatter->asEmail($model->email) ?></td>
        <td class="text-center align-middle"><?= Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]) ?></td>
        <td class="text-center align-middle">
            <?= $model->status === 10 ?  Html::a('<i class="fas fa-edit text-primary"></i>', ['update-contact', 'id'=> $counterparty->id, 'contact' => $model->id]) : NULL ?>
            <?= $button ?>
        </td>
</tr>