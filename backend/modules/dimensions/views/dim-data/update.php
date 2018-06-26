<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\DimData */

$this->title = Yii::t('dim', 'Update {modelClass}: ', [
    'modelClass' => 'Dim Data',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('dim', 'Dim Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('dim', 'Update');
?>
<div class="dim-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
