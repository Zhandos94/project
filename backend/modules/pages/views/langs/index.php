<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $id integer */

$this->title = Yii::t('app', 'Aux Pages Langs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aux Pages Datas'), 'url' => ['/pages/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .aux-pages-langs-index td {
        white-space: pre-wrap;
        word-wrap: break-word;
        max-width: 600px;
        overflow-y: auto;
    }
    .publication-body{
        max-height: 320px;
    }
</style>
<div class="aux-pages-langs-index">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a(Yii::t('app', 'Create Aux Pages Langs'), ['create', 'id' => $id], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
                    'lang.name',
                    [
                        'attribute' => 'body',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::tag('div', $model->body, ['class' => 'publication-body']);
                        },
                        'contentOptions' => function(){
                        return ['style' => 'width:600px'];
                        }
                    ],
//                    'body',
                    'title',
//                    'description',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>
    </div>
</div>
