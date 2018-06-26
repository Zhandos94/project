<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\refs\models\RefRelationsTableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ref Relations Tables');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-relations-table-index">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a(Yii::t('app', 'Create Ref Relations Table'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'attribute' => 'parent_table_id',
                        'value' => 'parentTable.table_name'
                    ],
                    [
                        'attribute' => 'child_table_id',
                        'value' => 'childTable.table_name'
                    ],
                    'created_at',
                    'updated_at',
                    // 'created_by',
                    // 'updated_by',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>
    </div>
</div>
