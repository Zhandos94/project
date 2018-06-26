<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\AuxPagesData */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Aux Pages Data',
    ]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aux Pages Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="aux-pages-data-update">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
