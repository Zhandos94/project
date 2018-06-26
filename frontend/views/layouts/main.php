<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\assets\HelpIntroAsset;
use frontend\assets\HintEditAsset;
use yii\bootstrap\Modal;
use backend\modules\helps\models\HelpIntro;
//use common\modules\translate\services\WriteToJsService;

//$write = new WriteToJsService();
//$write->execute();

HelpIntroAsset::register($this);
//if (\Yii::$app->user->can('createHint')) {
    HintEditAsset::register($this);
//}
AppAsset::register($this);
$js = <<< JS

$('.lang-switch').on('click', function(){
	var lang = $(this).attr('data-lang');
	setLang(lang);
});

function setLang(lang) {
	$.ajax({
		 url:'/site/switch-lang',
		 data:{language:lang},
		 success: function(response) {
			 response = JSON.parse(response);
			location.reload();
			window._CURLANG = response.language;
		}
	});
}
JS;
$this->registerJs($js);
$this->registerJs("var _CURLANG = " . json_encode(substr(Yii::$app->language, 0, 2)) . ";", \yii\web\View::POS_HEAD);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
	<?php
	NavBar::begin([
		'brandLabel' => 'My Company',
		'brandUrl' => Yii::$app->homeUrl,
		'options' => [
			'class' => 'navbar-inverse navbar-fixed-top',
		],
	]);
	$menuItems = [
		['label' => 'Home', 'url' => ['/site/index']],
		['label' => 'About', 'url' => ['/site/about']],
		['label' => 'Contact', 'url' => ['/site/contact']],
	];
	if (YII_ENV_DEV && \Yii::$app->user->can('createHint')) {
		$menuItems[] = ['label' => 'Hints', 'url' => ['/#'], 'options' => ['class' => 'hints']];
	}
	if (Yii::$app->user->isGuest) {
		$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
		$menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
	} else {
		$menuItems[] = '<li>'
			. Html::beginForm(['/site/logout'], 'post')
			. Html::submitButton(
				'Logout (' . Yii::$app->user->identity->username . ')',
				['class' => 'btn btn-link logout']
			)
			. Html::endForm()
			. '</li>';
	}
	echo Nav::widget([
		'options' => ['class' => 'navbar-nav navbar-right'],
		'items' => $menuItems,
	]);
	NavBar::end();
	?>

	<div class="container-fluid">
		<?= Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>
		<?= Alert::widget() ?>
		<?= $content ?>
	</div>
</div>

<footer class="footer">
	<div class="container">
		<p class="pull-left">&copy; My Company <?= date('Y') ?></p>

		<p class="pull-right"><?= Yii::powered() ?></p>
	</div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<!--<script>-->
<!--	$.material.init();-->
<!--</script>-->
<?php
//if (YII_ENV_DEV && \Yii::$app->user->can('createHint')) {
	$model = new HelpIntro();
	Modal::begin([
		'header' => '<h3>' . Yii::t('app', 'Hints') . '</h3>',
		'id' => 'hint-modal',
	]);
	echo '<div id="hint-modal-content">';
	echo $this->render('@backend/modules/helps/views/default/_form', ['model' => $model]);
	echo '</div>';
	Modal::end();
//}
?>
