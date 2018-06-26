<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;
use backend\modules\document\models\DocCategory;
use \backend\modules\document\models\DocFormat;

/* @var $this yii\web\View */
/* @var $model backend\modules\document\models\docCatFormat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="doc-cat-format-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cat_id')->dropDownList( ArrayHelper::map(DocCategory::getCategory(), 'id', 'name'), ['class' => 'form-control', 'prompt' => YII::t('app','Select category')]) ?>

    <?= $form->field($model, 'for_id')->dropDownList( ArrayHelper::map(DocFormat::getFormat(), 'id', 'name'), ['class' => 'form-control', 'prompt' => YII::t('app','Select format')]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
