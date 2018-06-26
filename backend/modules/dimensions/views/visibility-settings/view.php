<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\DimVisibilitySettings */

$this->title = $model->parent_dim_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('dim', 'Dim Visibility Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dim-visibility-settings-view">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>

            <p>
                <?= Html::a(Yii::t('dim', 'Update'), ['update', 'parent_dim_id' => $model->parent_dim_id, 'child_dim_id' => $model->child_dim_id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('dim', 'Delete'), ['delete', 'parent_dim_id' => $model->parent_dim_id, 'child_dim_id' => $model->child_dim_id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('dim', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'parent_dim_id',
                    'child_dim_id',
                    'condition',
                    'disabled',
                    'created_at',
                    'updated_at',
                    'created_by',
                    'updated_by',
                ],
            ]) ?>

        </div>
    </div>
</div>
