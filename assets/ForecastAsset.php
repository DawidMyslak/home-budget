<?php

namespace app\assets;

use yii\web\AssetBundle;

class ForecastAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/forecast.css',
    ];
    public $js = [
        'js/forecast.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\AppAsset',
    ];
}
