<?php

namespace app\assets;

use yii\web\AssetBundle;

class StatisticAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/statistic.css',
    ];
    public $js = [
        'js/statistic.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\AppAsset',
    ];
}
