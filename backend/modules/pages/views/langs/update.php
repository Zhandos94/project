<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\AuxPagesLangs */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => 'Aux Pages Langs',
    ]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aux Pages Datas'), 'url' => ['/pages/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Aux Pages Langs'), 'url' => ['index', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id, 'lang_id' => $model->lang_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="aux-pages-langs-update">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
