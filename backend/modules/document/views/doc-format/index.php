<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\document\models\docFormatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title =  Yii::t('app', 'Doc Formats');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-format-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Doc Format'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end()?>
</div>
