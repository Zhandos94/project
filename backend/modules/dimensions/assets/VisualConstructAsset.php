<?php

namespace backend\modules\dimensions\assets;

use yii\web\AssetBundle;

class VisualConstructAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/dimensions/assets';
    public $css = [
        'css/visual_construct.css',
    ];
    public $js = [
        'js/jquery-ui.min.js',
        'js/jquery.livequery.min.js',
        'js/visual_construct.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];

}