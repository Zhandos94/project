<?php

use backend\modules\helps\models\HelpIntro;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model HelpIntro */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $message \backend\modules\translate\models\Message */
/* @var $sourceMessage \backend\modules\translate\models\SourceMessage */

$script = <<< JS
	var curr_form = $('.help-intro-form').parent();
	$('#helpintro-page_id').keyup(function () {
		sourceMessageCustomValue();
	});

	$('#helpintro-element_id').keyup(function () {
		sourceMessageCustomValue();
	});

	function sourceMessageCustomValue () {
		if ($(curr_form).hasClass('help-intro-update')) {
			$('#sourcemessage-message').val($('#helpintro-page_id').val() + ' - ' + $('#helpintro-element_id').val());
		} else {
			$('#helpintro-message').val($('#helpintro-page_id').val() + ' - ' + $('#helpintro-element_id').val());
		}
	}
	
	 function isCheckedMain() {
        if ($('#helpintro-is_main').is(':checked')) {
            $('#helpintro-step').attr('type', 'text');
        } else {
            $('#helpintro-step').attr('type', 'hidden');
        }
     }
     
     isCheckedMain();
	
	$('body').delegate('#helpintro-is_main', 'click', function () {
        isCheckedMain();
    });
	
	   
	
JS;
$this->registerJs($script, yii\web\View::POS_END);
?>

<div class="help-intro-form">

	<?php $form = ActiveForm::begin([
		'fieldConfig' => ['inputOptions' => ['class' => 'hint-input form-control']],
	]); ?>

	<?= $form->field($model, 'page_id')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'element_id')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'category')->textInput(['disabled' => 'true', 'value' => Yii::$app->getModule('helps')->params['category']]) ?>

	<?php
	if ($model->isNewRecord) {
		echo $form->field($model, 'message')->textInput(['maxlength' => true]);
	} else {
		echo $form->field($model, 'message')->textInput(['maxlength' => true, 'value' => $translate['message']]);
	}
	?>

    <?= $form->field($model, 'langs')->dropDownList(array_flip(Yii::$app->params['langs']) , ['options' => ['ru-RU' => ['Selected'=>'selected']]]) ?>

	<?php
	if ($model->isNewRecord) {
		echo $form->field($model, 'body')->textInput(['maxlength' => true]);
	} else {
		echo $form->field($model, 'body')->textInput(['maxlength' => true, 'value' => $translate['translation']]);
	}
	?>

    <?= $form->field($model, 'is_main')->checkbox(['style' => 'margin-left: 20px; vertical-align: sub;'], false) ?>

    <?= $form->field($model, 'step')->hiddenInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_only')->checkbox(['style' => 'margin-left: 20px; vertical-align: sub;'], false) ?>

	<?= $form->field($model, 'position')->dropDownList(Yii::$app->getModule('helps')->params['position'], ['prompt' => Yii::t('app', 'Prompt Position')]) ?>

	<?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'is_frontend')->hiddenInput(['value' => ''])->label(false) ?>

	<?= $form->field($model, 'update_model')->hiddenInput(['value' => ''])->label(false) ?>

	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['id' => 'add-hint', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
