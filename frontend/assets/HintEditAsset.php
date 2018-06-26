<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class HintEditAsset extends AssetBundle
{
    public $sourcePath = '@frontend/modules/helps/assets';
    public $css = [
    ];
    public $js = [
        'js/hint_edit.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'rmrevin\yii\fontawesome\AssetBundle',
    ];

}