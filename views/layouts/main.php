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
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
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
    
    $controller = Yii::$app->controller->id;
    if ($controller === 'subcategory') {
        $controller = 'category';
    }
    else if ($controller === 'import') {
        $controller = 'transaction';
    }
    
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
            ['label' => 'Statistics', 'url' => ['/statistic'], 'active' => 'statistic' === $controller],
            ['label' => 'Categories', 'url' => ['/category'], 'active' => 'category' === $controller],
            ['label' => 'Keywords', 'url' => ['/keyword'], 'active' => 'keyword' === $controller],
            ['label' => 'Transactions', 'url' => ['/transaction'], 'active' => 'transaction' === $controller],
            ['label' => 'Account', 'url' => ['/user/profile'], 'active' => 'user' === $controller],
        ];
    }
    
    $subitems = [
        'statistic' => [
            ['label' => 'Dashboard', 'url' => ['/statistic/index']],
            ['label' => 'Forecast', 'url' => ['/statistic/forecast']],
        ],
        'category' => [
            ['label' => 'Manage', 'url' => ['/category/index']],
            ['label' => 'Create Category', 'url' => ['/category/create']],
            ['label' => 'Create Subcategory', 'url' => ['/subcategory/create']],
        ],
        'keyword' => [
            ['label' => 'Manage', 'url' => ['/keyword/index']],
            ['label' => 'Create', 'url' => ['/keyword/create']],
            ['label' => 'Suggestions', 'url' => ['/keyword/suggestion']],
        ],
        'transaction' => [
            ['label' => 'Manage', 'url' => ['/transaction/index']],
            ['label' => 'Create', 'url' => ['/transaction/create']],
            ['label' => 'Import', 'url' => ['/import/create']],
            ['label' => 'Import History', 'url' => ['/import/index']],
        ],
        'user' => [
            ['label' => 'Profile', 'url' => ['/user/profile']],
            ['label' => 'Change Password', 'url' => ['/user/password']],
            [
                'label' => 'Logout',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post'],
            ],
        ]
    ];
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>
    
    <?php if (isset($this->params['subtitle'])): ?>
    
    <div class="module">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h1 class="title"><?= $this->title ?></h1>
                    <span class="subtitle"><?= $this->params['subtitle'] ?></span>
                </div>
                <div class="col-sm-8 buttons">
                <?php
                if (isset($subitems[$controller])) {
                    foreach ($subitems[$controller] as $item) {
                        $options = isset($item['linkOptions']) ? $item['linkOptions'] : [];
                        $options['class'] = 'btn btn-default';
                        echo Html::a($item['label'], $item['url'], $options);
                    }
                }
                ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <?= $content ?>
    </div>
    
    <?php else: ?>
    <?= $content ?>
    <?php endif; ?>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; HomeBudget.ie <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
