<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\refs\models\MetaTable */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Meta Table',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Meta Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="meta-table-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
