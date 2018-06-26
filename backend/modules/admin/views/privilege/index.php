<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
use backend\modules\admin\models\AuthType;
use backend\modules\admin\models\AuthItem;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\admin\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Privilege');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="auth-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'raw',
                'attribute' => 'name',
                'value' => function ($model) {
                    if ($model->name == AuthItem::getExistsRole($model->name)) {
                        return Html::a($model->name, ['/myadmin/privilege/show-role',
                            'id' => $model->name,]);
                    }
                    else {
                        return $model->name;
                    }
                }
            ],
            'description:text',
            'rule_name',
            [
                'attribute' => 'type',
                'value' => 'authType.description',
                'filter' => Html::activeDropDownList($searchModel, 'type',
                    ArrayHelper::map(AuthType::find()->asArray()->all(), 'type', 'description'),
                    ['class' => 'form-control', 'prompt' => 'Select type']),
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
