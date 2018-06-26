<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('dim', 'Lot Dimensions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lot-dimensions-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('dim', 'Create Lot Dimensions'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'dim_id',
            'lot_type_id',
            'row_num',
            'col_count',
            'order_in_row',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
