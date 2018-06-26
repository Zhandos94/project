<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\translate\models\SourceMessage;
use backend\modules\translate\models\Message;

/* @var $this yii\web\View */
/* @var $model common\models\HelpIntro */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Help Intros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="help-intro-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Delete', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Are you sure you want to delete this item?',
				'method' => 'post',
			],
		]) ?>
	</p>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'page_id',
			'element_id',
			[
				'attribute' => 'source message',
				'value' => SourceMessage::findOne($model->body)->message,
			],
			[
				'attribute' => 'body',
				'value' => Message::find()->where(['id' => $model->body, 'language' => Yii::$app->language])->one()->translation,
			],
            'is_only',
            'is_main',
			'description',
			'position',
		],
	]) ?>

</div>