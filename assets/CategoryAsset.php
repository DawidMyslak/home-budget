<?php

namespace app\assets;

use yii\web\AssetBundle;

class CategoryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/category.css',
    ];
    public $js = [
        'js/category.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\AppAsset',
    ];
}
