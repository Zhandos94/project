<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\pages\models\AuxPagesLangs */
/* @var $form yii\bootstrap\ActiveForm */

$allowEdit = !$model->isNewRecord;

$allowEditIndex = $allowEdit && ($model->data->code == 'index');

$js = <<< js
    $('#lang-select').on('change', function(){
        if($(this).val() !== ''){
            $('.pages-langs-data').show();
        } else {
            $('.pages-langs-data').hide();
        }
    });
if($('#lang-select').val() !== ''){
    $('.pages-langs-data').show();
}
js;

$this->registerJs($js);
?>

<div class="aux-pages-langs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lang_id')->dropDownList(\common\models\SysLang::langs(), ['id' => 'lang-select',
        'prompt' => Yii::t('app', 'Select language'), 'disabled' => $allowEdit]) ?>

    <div class="pages-langs-data" hidden>

        <?= $form->field($model, 'body')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'full',
        ]) ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'disabled' => $allowEditIndex]) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
