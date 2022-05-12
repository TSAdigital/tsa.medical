<?php

/* @var $model app\models\Work */
/* @var $worker app\models\Worker */

use yii\helpers\Html;

$model->status === 10 ? $class = 'success' : $class = 'danger';
?>
<tr>
    <td class="align-middle"><?= $model->getDepartment_name() ?></td>
    <td class="align-middle"><?= $model->getEmploymentName() ?></td>
    <td class="align-middle"><?= $model->getPosition_name() ?></td>
    <td class="text-center align-middle"><?= $model->bet ?></td>
    <td class="text-center align-middle"><?= Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]) ?></td>
    <td class="text-center align-middle">
        <?= (Yii::$app->user->can('workView') or Yii::$app->user->can('admin')) ? Html::a('<i class="fas fa-sign-in-alt text-muted"></i>', ['view-work', 'id'=> $worker->id, 'work' => $model->id], ['class' => 'btn m-0 p-0']) : Html::a('<i class="fas fa-sign-in-alt text-muted"></i>', ['view-work', 'id'=> $worker->id, 'work' => $model->id], ['class' => 'btn disabled m-0 p-0']) ?>
    </td>
</tr>
