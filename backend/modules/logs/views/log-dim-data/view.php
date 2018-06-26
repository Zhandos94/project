<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\logs\models\LogDimData */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Dim Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-dim-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'action',
            'dim_id',
            'date',
        ],
    ]) ?>

</div>
