<?php

/* @var $model app\models\Passport */
/* @var $counterparty app\models\CounterpartyFl */

use yii\helpers\Html;

?>
<tr>
        <td class="text-center"><?= $model->passport_serial ?></td>
        <td class="text-center"><?= $model->passport_number ?></td>
        <td class="text-center"><?= $model->passport_date ?></td>
        <td class="text-center"><?= $model->passport_department_code ?></td>
        <td><?= $model->passport_issued ?></td>
        <td><?= $model->passport_birthplace ?></td>
        <td class="text-center">
            <?= Html::a('<i class="fas fa-edit text-primary"></i>', ['update-passport', 'id'=> $counterparty->id, 'passport' => $model->id]) ?>
            <?= Html::a('<i class="fas fa-ban text-danger"></i>', ['blocked-passport', 'id' => $model->id]) ?>
        </td>
</tr>