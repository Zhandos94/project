<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\refs\models\MetaTable */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="meta-table-form">
    <div class="panel">
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'table_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'model_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'disabled')->checkbox() ?>

            <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
