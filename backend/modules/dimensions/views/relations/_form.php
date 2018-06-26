<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\dimensions\models\DimRelations */
/* @var $form yii\bootstrap\ActiveForm */

$relService = new \backend\modules\dimensions\services\RelationService();
?>

<div class="dim-relations-form">
    <div class="panel">
        <div class="panel-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'parent_dim_id')->dropDownList($relService->getRefDimensions(), [
                    'prompt' => Yii::t('dim', 'Select code of parent dimension')
            ]) ?>

            <?= $form->field($model, 'child_dim_id')->dropDownList($relService->getRefDimensions(),[
                    'prompt' => Yii::t('dim', 'Select code of child dimension')
            ]) ?>

            <?= $form->field($model, 'condition')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'disabled')->checkbox() ?>

            <?= $form->field($model, 'extra_toggle')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('dim', 'Create') : Yii::t('dim', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
