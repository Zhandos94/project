<?php

use yii\helpers\Html;
use backend\assets\VisualConstructAsset;

/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\LotDimensions */

$this->title = $model->dim_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('dim', 'Lot Dimensions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('var lot_type_id = ' . $model->lot_type_id . ';', \yii\web\View::POS_HEAD);

$js = <<< JS
$('#test-button').on('click', function () {
    $.ajax({
        type: 'post',
        url: '/dimensions/dim-data/visual-edit',
        data: {
            dimensions: {
                color: {row_num: 1, col_count: 3, order_in_row: 1},
                jdsh: {row_num: 1, col_count: 9, order_in_row: 2}
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
VisualConstructAsset::register($this);

?>
<div class="lot-dimensions-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('dim', 'Update'), ['update', 'dim_id' => $model->dim_id, 'lot_type_id' => $model->lot_type_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('dim', 'Delete'), ['delete', 'dim_id' => $model->dim_id, 'lot_type_id' => $model->lot_type_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('dim', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= $this->renderFile(Yii::getAlias('@frontend'). '/views/get-attr/_attributes.php', [
        'lotAttrErr' => json_encode([]),
        'lotTypeId' => $model->lot_type_id,
    ]) ?>

    <form>
        <div id="visiual_construct"></div>
        <button type="button" class="btn btn-success" id="add-row">+</button>
        <hr>
        <?= Html::submitButton(Yii::t('dim', 'Apply'), ['class' => 'btn btn-primary vc-button', 'id' => 'vc-apply']) ?>
        <?= Html::submitButton(Yii::t('dim', 'Save'), ['class' => 'btn btn-primary vc-button', 'id' => 'vc-save']) ?>
    </form>

</div>

<div class="row vc-row vc-row-clone" style="display: none">
    <i class="fa fa-plus add-col" aria-hidden="true"></i>
</div>

<div class="col-md-6 vc-col-clone" data-col-size="6" style="display: none">
    <span class="vc-col-size">
        <i class="fa fa-sort-asc vc-col-size-plus" aria-hidden="true"></i>
        <i class="fa fa-sort-desc vc-col-size-min" aria-hidden="true"></i>
    </span>
</div>