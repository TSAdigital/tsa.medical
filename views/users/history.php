<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $actionsHistory yii\data\ActiveDataProvider */

$this->title = 'История: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'История';
$this->params['buttons'] = [
    'undo' => Html::a('<i class="far fa-arrow-alt-circle-left text-muted"></i>Вернуться', ['view', 'id' => $model->id], ['class' => 'btn btn-app'])
];
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body mb-0 pb-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 mb-0 pb-0">

                    <?php
                    $tempalte = "
                                {summary}       
                                <div class='timeline mt-3 pb-2'>
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
                            $result = $this->render('_list_history',
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
