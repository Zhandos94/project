<?php
/**
 * Created by BADI.
 * DateTime: 14.12.2016 14:53
 */

namespace common\assets;


use yii\web\AssetBundle;

class AutoNumericAsset extends AssetBundle
{
    public $sourcePath = '@bower/autoNumeric';
    public $baseUrl = '@web';

    public $js = [
        'autoNumeric-min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init(){
        parent::init();
    }
}