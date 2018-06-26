<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\logs\models\LogDimData */

$this->title = 'Create Log Dim Data';
$this->params['breadcrumbs'][] = ['label' => 'Log Dim Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-dim-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
