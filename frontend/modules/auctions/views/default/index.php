<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \frontend\modules\auctions\models\AucData */

$this->title = Yii::t('app', 'Auto Tables');
$this->params['breadcrumbs'][] = $this->title;
Yii::info('qwe', 'auc_log');
?>
<div class="auto-table-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a(Yii::t('app', 'Create Auto Table'), ['create'], ['class' => 'btn btn-success']) ?>
	</p>
	<?php Pjax::begin(['enablePushState' => true]); ?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'id',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>
	<?php Pjax::end(); ?>

</div>
