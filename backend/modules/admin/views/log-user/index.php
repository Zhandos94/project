<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
use backend\modules\admin\models\LogUserStatus;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\admin\models\LogUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Log Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id_user',
                'value' => 'user.username',
            ],
            'reason',
            [
                'attribute' => 'id_status',
                'value' => 'logUserStatus.description',
                'filter' => Html::activeDropDownList($searchModel, 'id_status',  ArrayHelper::map(LogUserStatus::find()->asArray()->all(), 'id', 'description'), ['class' => 'form-control', 'prompt' => 'Select status']),
            ],
            'date',

        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
