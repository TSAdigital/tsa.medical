<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $actionsHistory yii\data\ActiveDataProvider */
/* @var $model app\models\User */


$this->title = 'Последняя активность';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body pb-0">
                    <?php
                        $tempalte = "
                            {summary}       
                            <div class='timeline mt-3'>
                                {items}
                                <div>
                                    <i class='fas fa-clock bg-gray'></i>
                                </div>
                            </div>
                            {pager}
                        ";
                    ?>

                    <?= ListView::widget([
                        'dataProvider' => $actionsHistory,
                        'layout' => $tempalte,
                        'itemOptions' => [
                            'tag' => false,
                        ],
                        'itemView' => function ($model)
                        {
                            static $prevDate = null;
                            $result = $this->render('_list',
                                ['model'=>$model, 'printDate' => $prevDate != date('d.m.Y', $model->created_at)]);
                            $prevDate = date('d.m.Y', $model->created_at);
                            return $result;
                        },
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>