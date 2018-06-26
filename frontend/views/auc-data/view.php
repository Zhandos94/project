<?php

use yii\helpers\Html;
// use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use common\services\dimensions\Get;
use common\models\LotAttributeVal;

/* @var $this yii\web\View */
/* @var $model frontend\models\AucData */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auc Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$get = new Get();

$js = <<< JS

	$('select, input, textarea').not('[id^=helpintro],[type=hidden]').prop('disabled', true).each(function () {
		if ($(this).val() === '') {
			$(this).closest('.form-group').hide();
		}
	});
	$('#auction_submit').hide();
	$('textarea').not('[id^=helpintro]').attr('rows', 1);

JS;
$this->registerJs($js);
?>

<style media="screen">
	.form-group {
		margin: 0;
	}
	.form-group label.control-label {
		margin: 0;
	}
	textarea {
		padding: 0;
	}
</style>

<div class="auc-data-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
				'method' => 'post',
			],
		]) ?>
	</p>

	<?= $this->render('_form', [
		'model' => $model,
		'lotModel' => $lotModel,
		'lotAttrErr' => $lotAttrErr,
	]) ?>

</div>
