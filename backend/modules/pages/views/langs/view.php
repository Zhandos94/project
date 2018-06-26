<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\AuxPagesLangs */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aux Pages Datas'), 'url' => ['/pages/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aux Pages Langs'), 'url' => ['index', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .st-page-body {
        border: 1px groove;
    }
</style>
<div class="aux-pages-langs-view">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id, 'lang_id' => $model->lang_id],
                    ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id, 'lang_id' => $model->lang_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'lang.name',
                    'body',
                    'title',
                ],
            ]) ?>

        </div>
    </div>
</div>

<div class="st-page-body">
    <?= $model->body ?>
</div>
