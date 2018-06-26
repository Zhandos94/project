<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
use backend\modules\admin\models\UserSearch;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\admin\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Grand Access');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            [
                'attribute' => 'status',
                'value' => 'logUserStatus.name',
                'filter' => Html::activeDropDownList($searchModel, 'status',
                    ArrayHelper::map(UserSearch::getUserStatusName(), 'status', 'name'),
                    ['class' => 'form-control',
                        'prompt' => 'Select status']),
            ],
            'created_at:date',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],

        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>


