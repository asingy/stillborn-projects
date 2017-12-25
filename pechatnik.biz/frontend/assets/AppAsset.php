<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
        'css/material-design-iconic-font.min.css',
        'css/appup-icon.css',
        'css/slick.css',
        'css/style.css',
        'css/responsive.css',
        'https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700',
    ];
    public $js = [
      'js/modernizr-2.8.3.min.js',
      'js/smoothscroll.js',
      'js/jquery.nav.js',
      'js/slick.min.js',
      'js/inputmask.js',
      'js/jquery.inputmask.js',
      'js/slider.js',
      'js/create.js',
      'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
