<?php

/* @var $model app\models\Vaccination */
/* @var $worker app\models\Worker */

use yii\helpers\Html;

$model->status === 10 ? $class = 'success' : $class = 'danger';
?>
<tr>
    <td class="align-middle"><?= $model->getVaccine_name() ?></td>
    <td class="align-middle"><?= $model->getCounterparty_name() ?></td>
    <td class="text-center align-middle"><?= $model->start_date ?></td>
    <td class="text-center align-middle"><?= $model->end_date ?></td>
    <td class="text-center align-middle"><?= Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]) ?></td>
    <td class="text-center align-middle">
        <?= (Yii::$app->user->can('vaccinationView') or Yii::$app->user->can('admin')) ? Html::a('<i class="fas fa-sign-in-alt text-muted"></i>', ['view-vaccination', 'id'=> $worker->id, 'vaccination' => $model->id], ['class' => 'btn m-0 p-0']) : Html::a('<i class="fas fa-sign-in-alt text-muted"></i>', ['view-vaccination', 'id'=> $worker->id, 'vaccination' => $model->id], ['class' => 'btn disabled m-0 p-0']) ?>
    </td>
</tr>
