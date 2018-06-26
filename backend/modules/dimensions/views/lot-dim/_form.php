<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\LotDimensions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lot-dimensions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dim_id')->textInput() ?>

    <?= $form->field($model, 'lot_type_id')->textInput() ?>

    <?= $form->field($model, 'row_num')->textInput() ?>

    <?= $form->field($model, 'col_count')->textInput() ?>

    <?= $form->field($model, 'order_in_row')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('dim', 'Create') : Yii::t('dim', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
