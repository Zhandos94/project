<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\docCatFormat */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Doc Cat Formats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-cat-format-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'cat_id',
            'for_id',
        ],
    ]) ?>

</div>
