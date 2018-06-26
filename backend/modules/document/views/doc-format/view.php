<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\docFormat */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Doc Formats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-format-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
