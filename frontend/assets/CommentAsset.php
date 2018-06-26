<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class CommentAsset extends AssetBundle
{
	public $sourcePath = '@frontend/modules/comments/assets';
	public $css = [
		'css/comment.css'
	];
	public $js =[
		'js/jquery.cookie.js',
		'js/render_comment.js',
		'js/comment.js',
		'js/paginator.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
		'rmrevin\yii\fontawesome\AssetBundle',
	];

}
