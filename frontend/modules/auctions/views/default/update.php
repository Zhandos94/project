<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \frontend\modules\auctions\models\AucData */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Auto Table',
]) . ' ' . $model->agent_phone;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Auto Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->agent_phone, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="auto-table-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
