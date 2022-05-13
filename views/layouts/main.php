<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use dominus77\sweetalert2\Alert;
use hail812\adminlte3\assets\AdminLteAsset;
use hail812\adminlte3\assets\FontAwesomeAsset;
use yii\helpers\Html;
use yii\helpers\Url;

FontAwesomeAsset::register($this);
AdminLteAsset::register($this);
$this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback');
AppAsset::register($this);
$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $this->registerLinkTag(['rel' => 'icon', 'type' => 'image/svg+xml', 'href' => Url::to(['/favicon.svg'])]); ?>
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Yii::$app->name ?> - <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="sidebar-mini layout-fixed">
<div class="preloader">
    <div class="preloader__row">
    </div>
</div>
<?php $this->beginBody() ?>
<?= Alert::widget(['useSessionFlash' => true]) ?>
<div class="wrapper">
    <!-- Navbar -->
    <?= $this->render('navbar', ['assetDir' => $assetDir]) ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?= $this->render('sidebar', ['assetDir' => $assetDir]) ?>

    <!-- Content Wrapper. Contains page content -->
    <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <?= $this->render('control-sidebar') ?>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?= $this->render('footer') ?>
</div>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
