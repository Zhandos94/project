<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\DimVisibilitySettings */

$this->title = Yii::t('dim', 'Update {modelClass}: ', [
    'modelClass' => 'Dim Visibility Settings',
]) . $model->parent_dim_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('dim', 'Dim Visibility Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->parent_dim_id, 'url' => ['view', 'parent_dim_id' => $model->parent_dim_id, 'child_dim_id' => $model->child_dim_id]];
$this->params['breadcrumbs'][] = Yii::t('dim', 'Update');
?>
<div class="dim-visibility-settings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
