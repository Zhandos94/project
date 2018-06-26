<?php

use backend\modules\dimensions\assets\VisualConstructAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $lotDimensions array */
/* @var $lotTypeId integer */

$this->title = Yii::t('dim', 'Visual Construct');
$this->params['breadcrumbs'][] = ['label' => Yii::t('dim', 'Lot Dimensions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('var lot_dimensions = ' . json_encode($lotDimensions) . ';', \yii\web\View::POS_HEAD);
$this->registerJs('var lot_type_id = ' . $lotTypeId . ';', \yii\web\View::POS_HEAD);

VisualConstructAsset::register($this);

?>

<div class="dim-data-visual-construct">
    <div class="panel">
        <div class="panel-body">

            <h1><?= Html::encode($this->title) ?></h1>

            <?= $this->renderFile(Yii::getAlias('@frontend') . '/views/get-attr/_attributes.php', [
                'lotAttrErr' => json_encode([]),
                'lotTypeId' => $lotTypeId,
            ]) ?>

            <hr>

            <span id="not_active_toggle">Not active list<i class="fa fa-chevron-down" aria-hidden="true"></i></span>
            <div id="not_active_dimensions"><ul></ul></div>

            <div id="visiual_construct"></div>
            <button type="button" class="btn btn-success" id="add-row">+</button>

            <hr>

            <?= Html::submitButton(Yii::t('dim', 'Apply'), ['class' => 'btn btn-primary vc-button', 'id' => 'vc-apply']) ?>
            <?= Html::submitButton(Yii::t('dim', 'Save'), ['class' => 'btn btn-primary vc-button', 'id' => 'vc-save']) ?>

        </div>
    </div>
</div>
