<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\logs\models\LogDimData */

$this->title = Yii::t('app', 'Document Update: ') . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-dim-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
