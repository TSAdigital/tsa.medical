<?php

use app\models\CounterpartyFl;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CounterpartyFlSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Контрагенты ФЛ';
$this->params['breadcrumbs'][] = $this->title;
$disabled_create = (Yii::$app->user->can('counterpartyFlCreate') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
$this->params['buttons'] = ['create' => Html::a('<i class="fas fa-plus-circle text-success"></i>Добавить', ['create'], ['class' => 'btn btn-app' . $disabled_create])];
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
                                    return (Yii::$app->user->can('counterpartyFlView') or Yii::$app->user->can('admin')) ? Html::a($data->last_name, ['counterparties-fl/view','id'=>$data->id], ['title' => 'View','class'=>'no-pjax']) : $data->last_name;
                                }
                            ],
                            [
                                'attribute'=>'first_name',
                                'options' => ['width'=>'20%'],
                                'format'=>'raw',
                                'value' => function($data)
                                {
                                    return (Yii::$app->user->can('counterpartyFlView') or Yii::$app->user->can('admin')) ? Html::a($data->first_name, ['counterparties-fl/view','id'=>$data->id], ['title' => 'View','class'=>'no-pjax']) : $data->first_name;
                                }
                            ],
                            [
                                'attribute'=>'middle_name',
                                'options' => ['width'=>'20%'],
                                'format'=>'raw',
                                'value' => function($data)
                                {

                                    return (Yii::$app->user->can('counterpartyFlView') or Yii::$app->user->can('admin')) ?  Html::a($data->middle_name, ['counterparties-fl/view','id'=>$data->id], ['title' => 'View','class'=>'no-pjax']) : $data->middle_name;
                                }
                            ],
                            [
                                'attribute'=>'snils',
                                'options' => ['width'=>'20%'],
                                'headerOptions' => ['style' => 'text-align: center !important;'],
                                'contentOptions' => ['style' => 'text-align: center !important;'],
                                'value' => function($data)
                                {
                                    return Yii::$app->formatter->asSnils($data->snils);
                                }

                            ],
                            //'snils',
                            //'inn',
                            [
                                'filter' => CounterpartyFl::getStatusesArray(),
                                'attribute' => 'status',
                                'options' => ['width'=>'20%'],
                                'headerOptions' => ['style' => 'text-align: center !important;'],
                                'contentOptions' => ['style' => 'text-align: center !important;'],
                                'format' => 'raw',
                                'value' => function ($model, $key, $index, $column) {
                                    /** @var CounterpartyFl $model */
                                    /** @var \yii\grid\DataColumn $column */
                                    $value = $model->{$column->attribute};
                                    switch ($value) {
                                        case CounterpartyFl::STATUS_ACTIVE:
                                            $class = 'success';
                                            break;
                                        case CounterpartyFl::STATUS_INACTIVE:
                                            $class = 'danger';
                                            break;
                                        default:
                                            $class = 'default';
                                    };
                                    $html = Html::tag('span', Html::encode($model->getStatusName()), ['class' => 'badge badge-' . $class]);
                                    return empty($value) ? null : $html;
                                },

                            ],
                            //'created_at',
                            //'updated_at',

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