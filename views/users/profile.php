<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = 'Профиль пользователя';
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <i class="far fa-user" style="font-size: 24px;"></i>
                    </div>

                    <h3 class="profile-username text-center"><?= $model->username?></h3>
                    <p class="text-muted text-center"><?= $model->getRolesName() ?></p>
                    <a href="mailto:<?= $model->email?>" class="btn btn-primary btn-block"><b>Отправить сообщение</b></a>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <h3 class="card-title">Последняя активность</h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="timeline">

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
                                'itemView' => function ($model, $key, $index, $widget)
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
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>