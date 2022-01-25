<?php

use app\models\Department;
use app\models\User;
use yii\helpers\Html;

?>
<?php
$months = array( 1 => 'января' , 'февраля' , 'марта' , 'апреля' , 'мая' , 'июня' , 'июля' , 'августа' , 'сентября' , 'октября' , 'ноября' , 'декабря' );
$date = date('d ', $model->created_at) . date($months[date('n', $model->created_at)] . date(' Y', $model->created_at));
$department = Department::findOne($model->current_record);
$users = User::findOne($model->current_record);
?>
<?php if($printDate): ?>
    <div class="time-label">
        <span class="bg-secondary"><?= $date ?></span>
    </div>
<?php endif; ?>
<!-- timeline item -->
<div>
    <i class="<?= $model->icon ?>"></i>
    <div class="timeline-item">
        <span class="time"><i class="fas fa-clock"></i> <?= date('H:m:s', $model->created_at) ?></span>
        <h3 class="timeline-header no-border">
            <?= Html::a($model->user0->username, ['users/profile', 'id' => $model->user]) ?>
            <?= $model->action ?>
            <?php
                switch ($model->category) {
                    case 'department':
                        echo Html::a($department->name, ['departments/view', 'id' => $model->current_record]);
                        break;
                    case 'user':
                        echo Html::a($users->username, ['users/profile', 'id' => $model->current_record]);
                        break;
                }
            ?>
        </h3>
    </div>
</div>
<!-- END timeline item -->
