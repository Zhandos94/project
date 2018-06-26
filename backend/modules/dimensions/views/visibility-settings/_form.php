<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\DimVisibilitySettings */
/* @var $form yii\bootstrap\ActiveForm */

$relService = new \backend\modules\dimensions\services\RelationService();
?>

<div class="dim-visibility-settings-form">
    <div class="panel">
        <div class="panel-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'parent_dim_id')->dropDownList($relService->getRefDimensions(true), [
                'prompt' => Yii::t('dim', 'Select code of parent dimension')
            ]) ?>

            <?= $form->field($model, 'child_dim_id')->dropDownList($relService->getRefDimensions(true),[
                'prompt' => Yii::t('dim', 'Select code of child dimension')
            ]) ?>

            <?= $form->field($model, 'condition')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'disabled')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('dim', 'Create') : Yii::t('dim', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
