<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AucData */
/* @var $lotAttrErr string */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Auc Data',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auc Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="auc-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'lotModel' => $lotModel,
        'lotAttrErr' => $lotAttrErr,
    ]) ?>

</div>
