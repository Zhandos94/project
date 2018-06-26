<?php

use yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use yii\grid\GridView;
use backend\modules\logs\models\User;
use backend\modules\logs\models\LogDimData;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\logs\models\LogDimDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Dim Datas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-dim-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'user_id',
                'value' => 'user.username',
                'filter' => Html::activeDropDownList($searchModel, 'user_id',  ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username'), ['class' => 'form-control', 'prompt' => 'Select User']),
            ],
            [
                'attribute' => 'action',
                'value' => 'action',
                'filter' => Html::activeDropDownList($searchModel, 'action', $searchModel::logDimAction() ,['class' => 'form-control', 'prompt' => 'Select Action']),
            ],
            [
                'attribute' => 'dim_id',
                'value' => 'dimData.name',
            ],
            [
                'attribute' => 'date',
            ],
//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
