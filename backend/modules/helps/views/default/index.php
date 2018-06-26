<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\helps\models\HelpIntroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Help Intros';
$this->params['breadcrumbs'][] = $this->title;

function showFilter($param, $translate)
{
    if (!empty(trim($param))) {
        echo $translate;
    }
}
?>
<div class="help-intro-index">

	<h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <hr>

	<p>
		<?= Html::a('Create Help Intro', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

    <p>
        <?php
        showFilter($searchModel->is_main, Yii::t('app', 'filter-main'));
        showFilter($searchModel->is_only, Yii::t('app', 'filter-only'));
        ?>
    </p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'page_id',
			'element_id',
			[
				'attribute' => 'source message',
				'value'     => 'sourceMessage.message'
			],
			[
				'attribute' => 'body',
				'value'     => 'messageModel.translation'
			],
            'is_main',
            'step',
            'is_only',
			'position',
			'description',

			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>
</div>
