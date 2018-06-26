<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\admin\models\AuthRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Detail information');
$this->params['breadcrumbs'][] = ['label' => 'Privilege', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="auth-rule-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'item_name',
            'user.username',
        ],
    ]); ?>

</div>
