<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\refs\models\RefDynamicTableName */
/* @var $dataModels \backend\modules\refs\models\RefDynamicTableData */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Ref Dynamic Names',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ref Dynamic Names'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="ref-dynamic-names-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'dataModels' => $dataModels,
    ]) ?>

</div>
