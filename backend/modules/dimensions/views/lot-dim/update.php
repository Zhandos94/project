<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\LotDimensions */

$this->title = Yii::t('dim', 'Update {modelClass}: ', [
    'modelClass' => 'Lot Dimensions',
]) . $model->dim_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('dim', 'Lot Dimensions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dim_id, 'url' => ['view', 'dim_id' => $model->dim_id, 'lot_type_id' => $model->lot_type_id]];
$this->params['breadcrumbs'][] = Yii::t('dim', 'Update');
?>
<div class="lot-dimensions-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
