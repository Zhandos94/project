<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\Document */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    --><?//= $form->field($model, 'cat_id')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'com_id')->textInput() ?>

<!--    --><?//= $form->field($model, 'sign_status')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!--    --><?//= $form->field($model, 'save_name')->textInput(['maxlength' => true]) ?>
<!---->
<!--    --><?//= $form->field($model, 'create_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
