<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\dimensions\models\DimVisibilitySettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('dim', 'Dim Visibility Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dim-visibility-settings-index">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a(Yii::t('dim', 'Create Dim Visibility Settings'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'parent_dim_id',
                    'child_dim_id',
                    'condition',
                    'disabled',
                    'created_at',
                    // 'updated_at',
                    // 'created_by',
                    // 'updated_by',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>
    </div>
</div>
