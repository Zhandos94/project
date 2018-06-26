<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Meta Tables');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meta-table-index">
    <div class="panel">
        <div class="panel-body">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a(Yii::t('app', 'Create Meta Table'), ['create'], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('app', 'Dynamic References'), ['/refs/dynamic/index'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Reference relations'), ['/refs/relations'], ['class' => 'btn btn-info']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//            'id',
                    [
                        'attribute' => 'table_name',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->disabled != 1) {
                                return Html::a($model->table_name,
                                    ['default/index', 'table_name' => $model->table_name]);
                            } else {
                                return $model->table_name;
                            }
                        }
                    ],
                    'model_name',
                    [
                        'attribute' => 'disabled',
                        'value' => function ($model) {
                            if ($model->disabled == Yii::$app->getModule('refs')->params['locked']) {
                                return Yii::t('app', 'Locked');
                            } else {
                                return Yii::t('app', 'Unlocked');
                            }
                        }
                    ],
                    'description',
//            'created_at',
                    // 'updated_at',
                    // 'updated_by',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
