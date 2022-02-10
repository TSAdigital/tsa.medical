<?php

/* @var $this yii\web\View */
/* @var $model app\models\Counterparty */

$this->title = 'Новый Контрагент';
$this->params['breadcrumbs'][] = ['label' => 'Контрагенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                    <?=$this->render('_form', [
                        'model' => $model
                    ]) ?>
            </div>
        </div>
    </div>
</div>