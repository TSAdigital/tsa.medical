<?php

/* @var $model app\models\ActionHistory */
/* @var $printDate */

use yii\helpers\Html;
use \yii\helpers\HtmlPurifier;

?>
<?php
$months = array( 1 => 'января' , 'февраля' , 'марта' , 'апреля' , 'мая' , 'июня' , 'июля' , 'августа' , 'сентября' , 'октября' , 'ноября' , 'декабря' );
$date = date('d ', $model->created_at) . date($months[date('n', $model->created_at)] . date(' Y', $model->created_at));
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
            <?= Html::a(HtmlPurifier::process($model->user0->username), ['users/profile', 'id' => $model->user]) ?>
            <?= $model->action ?>
            <?= Html::a(HtmlPurifier::process($model->text), [$model->url, 'id' => $model->current_record]) ?>
        </h3>
    </div>
</div>
<!-- END timeline item -->
