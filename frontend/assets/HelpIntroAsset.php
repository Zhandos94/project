<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class HelpIntroAsset extends AssetBundle
{
	public $sourcePath = '@frontend/modules/helps/assets';
	public $css = [
		'css/help.css',
		'css/introjs.css',
	];
	public $js = [
		'js/intro.js',
		'js/help.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
		'rmrevin\yii\fontawesome\AssetBundle',
	];

}
