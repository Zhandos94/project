<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\logs\models\LogDimData */

$this->title = 'Update Log Dim Data: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Dim Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-dim-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
