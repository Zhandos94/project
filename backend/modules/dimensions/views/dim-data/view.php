<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\DimData */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('dim', 'Dim Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$js = <<< JS

$('#test-button').on('click', function () {
    $.ajax({
        type: 'post',
        url: '/dimensions/dim-data/visual-edit',
        data: {
            dimensions: {
                rrrr: {row_num: 1, col_count: 3, order_in_row: 1},
                dateq: {row_num: 1, col_count: 9, order_in_row: 2}
            },
            lotTypeId: 2
        },
        success: function (response) {
            console.log(response);
        },
        error: function (response) {
            console.log(response);
        }
    });
});

JS;

$this->registerJs($js);
?>
<div class="dim-data-view">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>

            <button type="button" id="test-button">click for ajax</button>
            <p>
                <?= Html::a(Yii::t('dim', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('dim', 'Delete'), ['delete', 'id' => $model->id], [
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
                    'id',
                    'code',
                    'name',
                    'description',
                    'is_active',
                    'type_id',
                    'is_required',
                    'min_date',
                    'max_date',
                    'min_val',
                    'relation_min',
                    'max_val',
                    'relation_max',
                    'negative_allow',
                    'decimal_sym_num',
                    'max_length',
                    'min_length',
                    'ref_id',
                    'group_id',
                    'created_at',
                    'updated_at',
                    'created_by',
                    'updated_by',
                ],
            ]) ?>

            <?= $this->renderFile(Yii::getAlias('@frontend'). '/views/get-attr/_attributes.php', [
                    'lotAttrErr' => json_encode([]),
                'lotTypeId' => 1,
            ]) ?>

        </div>
    </div>
</div>
