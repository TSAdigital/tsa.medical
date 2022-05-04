<?php

/* @var $model app\models\WorkerFile */
/* @var $worker app\models\Worker */

use yii\helpers\Html;

$model->status === 10 ? $class = 'success' : $class = 'danger';
?>
<tr>
    <td class="align-middle"><?= ($model->status == 10 and file_exists($model->url) and !is_dir($model->url)) ? Html::a($model->name, ['workers/download', 'id'=> $worker->id, 'file' => $model->id]) : $model->name ?></td>
    <td class="text-center align-middle"><?= $model->date ?></td>
    <td class="text-center align-middle"><?= Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]) ?></td>
    <td class="text-center align-middle">
        <?= Html::a('<i class="fas fa-sign-in-alt text-muted"></i>', ['view-file', 'id'=> $worker->id, 'file' => $model->id]) ?>
    </td>
</tr>
