<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\ArrayHelper;
use backend\modules\document\models\Document;
use backend\modules\document\models\DocCategory;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\document\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Documents');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'raw',
                'attribute' => 'cat_id',
                'value' => 'docCategory.name',
                'filter' => Html::activeDropDownList($searchModel, 'cat_id',
                    ArrayHelper::map(DocCategory::getCategory(), 'id', 'name'),
                    ['class' => 'form-control', 'prompt' => YII::t('app', 'Select Category')]),
            ],
            'com_id',
            [
                'format' => 'raw',
                'attribute' => 'sign_status',
                'value' => function ($model) {
                    return  Document::getDocumentStatus($model->sign_status);
                },
                'filter' => Html::activeDropDownList($searchModel, 'sign_status',
                    ArrayHelper::map(Document::find()->asArray()->all(), 'sign_status', 'sign_status'),
                    ['class' => 'form-control', 'prompt' => 'Select status']),
            ],
            'name',
             'save_name',
             'created_at:date',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
    <?php yii\widgets\Pjax::end()?>
</div>
