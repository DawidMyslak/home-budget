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
            ['label' => 'Statistics', 'url' => ['/statistic'], 'active' => 'statistic' == Yii::$app->controller->id],
            ['label' => 'Categories', 'url' => ['/category'], 'active' => ('category' == Yii::$app->controller->id || 'subcategory' == Yii::$app->controller->id)],
            ['label' => 'Keywords', 'url' => ['/keyword'], 'active' => 'keyword' == Yii::$app->controller->id],
            ['label' => 'Transactions', 'url' => ['/transaction'], 'active' => ('transaction' == Yii::$app->controller->id || 'import' == Yii::$app->controller->id)],
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
    
    <?php if (isset($this->params['subtitle'])): ?>
    
    <div class="module">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="title"><?= $this->title ?></h1>
                    <span class="subtitle"><?= $this->params['subtitle'] ?></span>
                </div>
                <div class="col-sm-6 buttons">
                <?php if (isset($this->params['buttons'])): ?>
                    <?php foreach ($this->params['buttons'] as $button): ?>
                        <?= Html::a($button['label'], $button['url'], ['class' => 'btn btn-success']) ?>
                    <? endforeach; ?>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <?= $content ?>
    </div>
    
    <?php else: ?>
    
    <div class="container content">
        <?= $content ?>
    </div>
    
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
