<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
// use yii\bootstrap\Nav;
// use yii\bootstrap\NavBar;
// use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
// use yii\bootstrap\BootstrapThemeAsset;
use app\themes\semantic\Navbar;
use app\themes\semantic\Nav;
use app\themes\semantic\SemanticAsset;

SemanticAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/x-icon" href=" /favicon.ico">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="/bookcase.png"/>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="pusher">
    <div class="ui inverted vertical masthead center aligned segment">

    <?php
    Navbar::begin(/*[
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]*/);
    echo Nav::widget([
        'options' => ['class' => 'ui large secondary inverted pointing menu'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/site/login']] :
                [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
        ],
    ]);
    Navbar::end();
    ?>
    </div>

            <?= '' /*Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) */ ?>
            <?= $content ?>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; ТемоЦентр <?= date('Y') ?></p>

        <!-- p class="pull-right"><?= Yii::powered() ?></p -->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
