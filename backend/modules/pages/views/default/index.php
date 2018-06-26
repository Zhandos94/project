<?php

use backend\modules\pages\models\AuxPagesLangs;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Aux Pages Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .aux-pages-data-index td {
        white-space: pre-wrap;
        word-wrap: break-word;
        max-width: 600px;
    }
</style>
<div class="aux-pages-data-index">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a(Yii::t('app', 'Create Aux Pages Data'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
                    [
                        'attribute' => 'code',
                        'format' => 'raw',
                        'value' => function ($model) {
                            /* @var $model \backend\modules\pages\models\AuxPagesData */
                            return Html::a($model->code, Url::toRoute(['/pages/langs/index', 'id' => $model->id]));
                        }
                    ],
                    'description',
//                    'is_public',
                    [
                        'attribute' => 'is_public',
                        'value' => function ($model) {
                            /* @var $model \backend\modules\pages\models\AuxPagesData */
                            $publicText = Yii::t('app', $model->is_public == 1 ? 'Public' : 'Non Public');
                            return $publicText;
                        }
                    ],
                    [
                        'label' => 'kz',
                        'format' => 'raw',
                        'value' => function ($model) {
                            /* @var $model \backend\modules\pages\models\AuxPagesData */
                            return Html::a('kz', ['/pages/langs/view', 'id' => $model->id, 'lang_id' => 1]);
                        },
                        'contentOptions' => function ($model) {
                            /* @var $model \backend\modules\pages\models\AuxPagesData */
                            if (AuxPagesLangs::isEmpty($model->id, 'kz-KZ')) {
                                return ['style' => 'background-color:orange'];
                            } else {
                                return [];
                            }
                        }
                    ],
                    [
                        'label' => 'ru',
                        'format' => 'raw',
                        'value' => function ($model) {
                            /* @var $model \backend\modules\pages\models\AuxPagesData */
                            return Html::a('ru', ['/pages/langs/view', 'id' => $model->id, 'lang_id' => 2]);
                        },
                        'contentOptions' => function ($model) {
                            /* @var $model \backend\modules\pages\models\AuxPagesData */
                            if (AuxPagesLangs::isEmpty($model->id, 'ru-RU')) {
                                return ['style' => 'background-color:orange'];
                            } else {
                                return [];
                            }
                        }
                    ],
                    [
                        'label' => 'en',
                        'format' => 'raw',
                        'value' => function ($model) {
                            /* @var $model \backend\modules\pages\models\AuxPagesData */
                            return Html::a('en', ['/pages/langs/view', 'id' => $model->id, 'lang_id' => 3]);
                        },
                        'contentOptions' => function ($model) {
                            /* @var $model \backend\modules\pages\models\AuxPagesData */
                            if (AuxPagesLangs::isEmpty($model->id, 'en-EN')) {
                                return ['style' => 'background-color:orange'];
                            } else {
                                return [];
                            }
                        }
                    ],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>
    </div>
</div>
