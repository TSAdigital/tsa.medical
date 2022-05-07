<?php

/* @var $model app\models\Certificate */
/* @var $worker app\models\Worker */

use yii\helpers\Html;

$model->status === 10 ? $class = 'success' : $class = 'danger';
?>
<tr>
    <td class="align-middle"><?= $model->getCounterparty_name() ?></td>
    <td class="align-middle"><?= $model->getSpecialization_name() ?></td>
    <td class="text-center align-middle"><?= $model->start_date ?></td>
    <td class="text-center align-middle"><?= $model->end_date ?></td>
    <td class="text-center align-middle"><?= Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]) ?></td>
    <td class="text-center align-middle">
        <?= Html::a('<i class="fas fa-sign-in-alt text-muted"></i>', ['view-certificate', 'id'=> $worker->id, 'certificate' => $model->id]) ?>
    </td>
</tr>
