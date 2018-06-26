<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\document\models\Document;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\Document */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'docCategory.name',
            'com_id',
            [
                'format' => 'raw',
                'attribute' => 'sign_status',
                'value' => Document::getDocumentStatus($model->sign_status),
            ],
            'name',
            'save_name',
            'created_at:date',
        ],
    ]) ?>

</div>
