<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
use yii\helpers\Html;

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header pb-0">
        <div class="container-fluid pb-0">
            <div class="row">
                <div class="col-sm-12 col-md-6 pb-0">
                    <h1 class="m-0 p-0">
                        <?php
                        if (!is_null($this->title)) {
                            echo \yii\helpers\Html::encode($this->title);
                        } else {
                            echo \yii\helpers\Inflector::camelize($this->context->id);
                        }
                        ?>
                    </h1>
                    <?php
                    echo Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'options' => [
                            'class' => 'breadcrumb mb-1 pb-0'
                        ]
                    ]);
                    ?>
                </div><!-- /.col -->
                <div class="col-sm-12 col-md-6 pb-0">
                    <p class="text-md-right mb-0">
                        <?= !empty($this->params['buttons']['create']) ? $this->params['buttons']['create'] : false?>
                        <?= !empty($this->params['buttons']['update']) ? $this->params['buttons']['update'] : false?>
                        <?= !empty($this->params['buttons']['block']) ? $this->params['buttons']['block'] : false?>
                        <?= !empty($this->params['buttons']['active']) ? $this->params['buttons']['active'] : false?>
                        <?= !empty($this->params['buttons']['history']) ? $this->params['buttons']['history'] : false?>
                    </p>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <?= $content ?><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>