<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * JRange plugin asset bundle.
 */
class JRangeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/jquery.range.css'
    ];
    public $js = [
      'js/jquery.range-min.js'
    ];
    public $depends = [

    ];
}
