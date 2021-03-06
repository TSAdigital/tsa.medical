<?php

use app\models\Counterparty;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CounterpartySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Контрагенты ЮЛ';
$this->params['breadcrumbs'][] = $this->title;
$disabled_create = (Yii::$app->user->can('counterpartyCreate') or Yii::$app->user->can('admin')) ? NULL : ' disabled';
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
                        'tableOptions' => ['class' => 'table table-striped '],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            [
                                'attribute'=>'name',
                                'options' => ['width'=>'60%'],
                                'format'=>'raw',
                                'value' => function($data)
                                {
                                    return (Yii::$app->user->can('counterpartyView') or Yii::$app->user->can('admin')) ? Html::a($data->name, ['counterparties/view','id'=>$data->id], ['title' => 'View','class'=>'no-pjax']) : $data->name;
                                }
                            ],
                            //'full_name',
                            [
                                'attribute' => 'inn',
                                'headerOptions' => ['style' => 'text-align: center !important;'],
                                'contentOptions' => ['style' => 'text-align: center !important;'],
                                'options' => ['width'=>'20%'],
                            ],
                            [
                                'filter' => Counterparty::getStatusesArray(),
                                'attribute' => 'status',
                                'options' => ['width'=>'20%'],
                                'headerOptions' => ['style' => 'text-align: center !important;'],
                                'contentOptions' => ['style' => 'text-align: center !important;'],
                                'format' => 'raw',
                                'value' => function ($model, $key, $index, $column) {
                                    /** @var Counterparty $model */
                                    /** @var \yii\grid\DataColumn $column */
                                    $value = $model->{$column->attribute};
                                    switch ($value) {
                                        case Counterparty::STATUS_ACTIVE:
                                            $class = 'success';
                                            break;
                                        case Counterparty::STATUS_INACTIVE:
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