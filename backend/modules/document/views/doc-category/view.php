<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\docCategory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Doc Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

</div>
