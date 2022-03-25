<?php

/* @var $model app\models\Contact */
/* @var $counterparty app\models\Counterparty */

use yii\helpers\Html;

$model->status === 10 ? $class = 'success' : $class = 'danger';
?>
<tr>
        <td class="align-middle"><?= $model->name ?></td>
        <td class="align-middle"><?= $model->getPositionName() ?></td>
        <td class="align-middle"><?= Yii::$app->formatter->asPhone($model->phone) ?></td>
        <td class="align-middle"><?= $model->phone_extension ?></td>
        <td class="align-middle"><?= Yii::$app->formatter->asEmail($model->email) ?></td>
        <td class="text-center align-middle"><?= Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]) ?></td>
        <td class="text-center align-middle">
            <?= Html::a('<i class="fas fa-sign-in-alt text-muted"></i>', ['view-contact', 'id'=> $counterparty->id, 'contact' => $model->id]) ?>
        </td>
</tr>