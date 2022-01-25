<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>

                    <?php Pjax::begin(); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'options' => ['class' => 'table-responsive'],
                        'tableOptions' => ['class' => 'table table-striped'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'username',
                                'options' => ['width'=>'30%'],
                                'value' => 'username',
                            ],
                            [
                                'attribute' => 'email',
                                'options' => ['width'=>'30%'],
                                'format' => 'raw',
                                'value' => function ($model) {return Yii::$app->formatter->asEmail($model->email);},
                            ],
                            [
                                'filter' => User::getStatusesArray(),
                                'attribute' => 'status',
                                'options' => ['width'=>'20%'],
                                'headerOptions' => ['style' => 'text-align: center !important;'],
                                'contentOptions' => ['style' => 'text-align: center !important;'],
                                'format' => 'raw',
                                'value' => function ($model, $key, $index, $column) {
                                    /** @var User $model */
                                    /** @var \yii\grid\DataColumn $column */
                                    $value = $model->{$column->attribute};
                                    switch ($value) {
                                        case User::STATUS_ACTIVE:
                                            $class = 'success';
                                            break;
                                        case User::STATUS_INACTIVE:
                                            $class = 'danger';
                                            break;
                                        default:
                                            $class = 'default';
                                    };
                                    $html = Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]);
                                    return empty($value) ? null : $html;
                                },

                            ],
                            [
                                'attribute' => 'roles',
                                'format' => 'raw',
                                'filter' => User::getRolesDropdown(),
                                'headerOptions' => ['style' => 'text-align: center !important;'],
                                'contentOptions' => ['style' => 'text-align: center !important;'],
                                'options' => ['width'=>'20%'],
                                'value' => function ($model, $key, $index, $column) {
                                    /** @var User $model */
                                    /** @var \yii\grid\DataColumn $column */
                                    $value = $model->{$column->attribute};
                                    switch ($value) {
                                        case User::ROLE_USER:
                                            $class = 'primary';
                                            break;
                                        case User::ROLE_ADMIN:
                                            $class = 'danger';
                                            break;
                                        default:
                                            $class = 'default';
                                    };
                                    $html = Html::tag('span', Html::encode($model->getRolesName()), ['class' => 'badge badge-' . $class]);
                                    return empty($value) ? null : $html;
                                },
                            ],
                            ['class' => 'hail812\adminlte3\yii\grid\ActionColumn', 'template'=>'{view}'],
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>