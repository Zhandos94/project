<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\document\models\Document;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Upload document'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'cat_id',
                'value' => 'docCategory.name',
            ],
            [
                'format' => 'raw',
                'attribute' => 'sign_status',
                'value' => function ($model) {
                    return $model->sign_status = Document::getDocumentStatus($model->sign_status);
                }
            ],
            'name',
             'save_name',
             'created_at:date',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

</div>
