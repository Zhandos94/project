<?php
/**
 * Created by BADI.
 * DateTime: 20.12.2016 16:56
 */


use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="dim-data-index">
    <div class="panel">
        <div class="panel-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'code',
                    'name',
                    'is_active',
                    'lotTypesCount',
//                    'lotTypeNames',
                    [
                        'attribute' => 'lotTypeNames',
                        'format' => 'raw',
                        'value' => 'lotTypeNames',
                    ],
                    [
                        'attribute' => 'type_id',
                        'value' => 'dataType.name'
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>
    </div>
</div>