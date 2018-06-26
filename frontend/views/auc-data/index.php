<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Auc Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auc-data-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Auc Data'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'source_auc_id',
            'number_anno',
            'cruser_id',
            'org_id',
            // 'subject_id',
            // 'lienor_id',
            // 'agent_id',
            // 'agent_phone',
            // 'agent_email:email',
            // 'agent_address',
            // 'pledgor',
            // 'payment_details',
            // 'margin_pay_cond',
            // 'notifications',
            // 'media_public',
            // 'colcat_id',
            // 'start_date',
            // 'end_date',
            // 'buy_status',
            // 'title_ru',
            // 'title_kz',
            // 'name_ru:ntext',
            // 'name_kz:ntext',
            // 'sale_type',
            // 'auction_type',
            // 'lastupdateuserid',
            // 'lastupdate',
            // 'count_lots',
            // 'start_sum',
            // 'margin_sum',
            // 'reserve_price',
            // 'increment',
            // 'imgname',
            // 'imgsavename',
            // 'venue',
            // 'region_id',
            // 'is_collateral',
            // 'apa_end_datetime',
            // 'is_direct_sale',
            // 'is_operator_ads',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
