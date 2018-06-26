<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\refs\models\RefRelationsTable */
/* @var $relCols \backend\modules\refs\models\RefRelationsColumns[] */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Ref Relations Table',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ref Relations Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="ref-relations-table-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'relCols' => $relCols
    ]) ?>

</div>
