<?php

namespace app\assets;

use yii\web\AssetBundle;

class StartAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.4.0/animate.min.css',
        'css/start.css',
    ];
    public $js = [
        'js/start.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\AppAsset',
    ];
}
