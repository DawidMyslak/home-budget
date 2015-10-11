<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'HomeBudget.ie',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    $items = [];
    if (Yii::$app->user->isGuest) {
        $items = [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => 'Login', 'url' => ['/site/login']],
        ];
    }
    else {
        $items = [
            [
                'label' => 'Statistics',
                'active' => 'statistic' == Yii::$app->controller->id,
                'items' => [
                    ['label' => 'Dashboard', 'url' => ['/statistic/index']],
                    ['label' => 'Forecast', 'url' => '#'],
                ],
            ],
            [
                'label' => 'Categories',
                'active' => 'category' == Yii::$app->controller->id,
                'items' => [
                    ['label' => 'Manage', 'url' => ['/category/index']],
                ],
            ],
            [
                'label' => 'Keywords',
                'active' => 'keyword' == Yii::$app->controller->id,
                'items' => [
                    ['label' => 'Manage', 'url' => ['/keyword/index']],
                    ['label' => 'Suggestions', 'url' => ['/keyword/suggestion']],
                ],
            ],
            [
                'label' => 'Transactions',
                'active' => 'transaction' == Yii::$app->controller->id,
                'items' => [
                    ['label' => 'Manage', 'url' => ['/transaction/index']],
                    ['label' => 'Import', 'url' => ['/transaction/import']],
                    ['label' => 'Categorise', 'url' => ['/transaction/categorise']],
                ],
            ],
            [
                'label' => 'Account',
                'active' => 'user' == Yii::$app->controller->id,
                'items' => [
                    ['label' => 'Profile', 'url' => ['/user/profile']],
                    ['label' => 'Change Password', 'url' => ['/user/password']],
                    '<li class="divider"></li>',
                    [
                        'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                    ],
                ],
            ],
        ];
    }
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Home Budget <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
