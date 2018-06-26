<?php
/**
 * Created by BADI.
 * DateTime: 20.12.2016 16:51
 */
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="panel">
    <div class="panel-body">
        <?= /** @noinspection PhpUnusedParameterInspection */
        GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'code',
                'name',
                [
                    'attribute' => 'dimensionCount',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /* @var $model \common\models\refs\RefLotTypes */
                        return Html::a($model->dimensionCount,
                            ['/dimensions/dim-data/filter-dims', 'lotTypeId' => $model->id],[
                                    'target' => '_blank'
                            ]);
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => Yii::t('dim', 'Visual Construct'),
                    'template' => '{visual-construct}',
                    'buttons' => [
                        'visual-construct' => function ($url) {
                            return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url);
                        },
                    ],
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>