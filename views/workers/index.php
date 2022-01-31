<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Worker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\WorkerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сотрудники';
$this->params['breadcrumbs'][] = $this->title;
$this->params['buttons'] = ['create' => Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create'], ['class' => 'btn btn-app'])];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body pb-0">

                    <?php Pjax::begin(); ?>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'options' => ['class' => 'table-responsive'],
                        'tableOptions' => ['class' => 'table table-striped'],

                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            [
                                'attribute'=>'last_name',
                                'options' => ['width'=>'20%'],
                                'format'=>'raw',
                                'value' => function($data)
                                {
                                    return
                                        Html::a($data->last_name, ['workers/view','id'=>$data->id], ['title' => 'View','class'=>'no-pjax']);
                                }
                            ],
                            [
                                'attribute'=>'firs_name',
                                'options' => ['width'=>'20%'],
                                'format'=>'raw',
                                'value' => function($data)
                                {
                                    return
                                        Html::a($data->firs_name, ['workers/view','id'=>$data->id], ['title' => 'View','class'=>'no-pjax']);
                                }
                            ],
                            [
                                'attribute'=>'middle_name',
                                'options' => ['width'=>'20%'],
                                'format'=>'raw',
                                'value' => function($data)
                                {
                                    return
                                        Html::a($data->middle_name, ['workers/view','id'=>$data->id], ['title' => 'View','class'=>'no-pjax']);
                                }
                            ],
                            [
                                'attribute'=>'department_name',
                                'options' => ['width'=>'25%'],
                                'format'=>'raw',
                                'value' => 'department_name'
                            ],
                            [
                                'filter' => Worker::getStatusesArray(),
                                'attribute' => 'status',
                                'options' => ['width'=>'15%'],
                                'headerOptions' => ['style' => 'text-align: center !important;'],
                                'contentOptions' => ['style' => 'text-align: center !important;'],
                                'format' => 'raw',
                                'value' => function ($model, $key, $index, $column) {
                                    /** @var Worker $model */
                                    /** @var \yii\grid\DataColumn $column */
                                    $value = $model->{$column->attribute};
                                    switch ($value) {
                                        case Worker::STATUS_ACTIVE:
                                            $class = 'success';
                                            break;
                                        case Worker::STATUS_INACTIVE:
                                            $class = 'danger';
                                            break;
                                        default:
                                            $class = 'default';
                                    };
                                    $html = Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]);
                                    return empty($value) ? null : $html;
                                },

                            ],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ]
                    ]); ?>

                    <?php Pjax::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>