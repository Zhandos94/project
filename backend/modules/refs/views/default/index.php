<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $table_name */
/* @var $columns */
/* @var $prim_key */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $table_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'References'), 'url' => ['meta/index']];;
$this->params['breadcrumbs'][] = $this->title;

$grid_columns = [['class' => 'yii\grid\SerialColumn']];
foreach ($columns as $key => $column) {
    $grid_columns[] = $column;
}
/** @noinspection PhpUnusedParameterInspection */
$grid_columns[] = [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view} {update} {delete}',
    'buttons' => [
        'update' => function ($url, $model) use ($table_name, $prim_key) {
            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                ['update', 'table_name' => $table_name, 'prim_key_val' => $model[$prim_key]]);
        },
        'view' => function ($url, $model) use ($table_name, $prim_key) {
            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                ['view', 'table_name' => $table_name, 'prim_key' => $model[$prim_key]]);
        },
        'delete' => function ($url, $model) use ($table_name, $prim_key) {
            return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                ['delete', 'table_name' => $table_name, 'prim_key' => $model[$prim_key]]);
        }
    ],

];
?>
<div class="msg-template-index">
    <div class="panel">
        <div class="panel-body">
            <h1><?= Html::encode($this->title) ?></h1>

            <?= Html::a(Yii::t('app', 'Create'), ['create', 'table_name' => $table_name], ['class' => 'btn btn-success']) ?>

            <?= Html::a(Yii::t('app', 'Sql'), ['generate-sql', 'table_name' => $table_name], ['class' => 'btn btn-primary']) ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => $grid_columns
            ]); ?>
        </div>
    </div>
</div>