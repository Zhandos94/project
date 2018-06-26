<?php

use common\services\dimensions\Get;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AucData */
/* @var $form yii\widgets\ActiveForm */
/* @var $lotAttrErr string */

$get = new Get();
$js = <<< JS

	$('#auction-colcat_id').on('change', function(){
	get_dynamic_form($(this).val());
});

function get_dynamic_form(value) {
	if(value != ''){
		$.ajax({
		type:'POST',
		data:{lotTypeId:value},
		url:'/get-attr/get-dynamic-form',
		success:function(response){
			$('#attr-form').html(response);
			$.material.init();
		}
	});
	}
}

$('#auction_submit').on('click', function(){

	preValidateConstructor();
})

JS;
$this->registerJs($js);

?>
<div class="auc-data-form">
	<div class="panel">
		<div class="panel-body">

			<?php $form = ActiveForm::begin(['id' => 'auction-form']); ?>

			<?= $form->field($model, 'lotTypeId')->dropDownList($get->lotTypesList(), [
				'prompt' => Yii::t('app', 'select type of lot'),
				'id' => 'auction-colcat_id'
			]) ?>

			<div id="attr-form">
				<?= $this->render('/get-attr/_attributes', [
					'lotModel' => $lotModel,
					'lotAttrErr' => $lotAttrErr
				]) ?>
			</div>

			<?= $form->field($model, 'name_ru')->textarea(['rows' => 6]) ?>

			<?= $form->field($model, 'name_kz')->textarea(['rows' => 6]) ?>

			<div class="form-group">
				<?= Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
					['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'auction_submit']) ?>
			</div>

			<?php ActiveForm::end(); ?>

		</div>
	</div>
</div>
