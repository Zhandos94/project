<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model \frontend\modules\comments\models\CommentForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $subject_id integer */

$model = new \frontend\modules\comments\models\CommentForm();

//$username = null;
$disabled = true;
if (!Yii::$app->user->isGuest){
	$username = \frontend\services\UserService::getNickname();
} else {
	$username = Yii::t('app', 'Anonym');
}

?>

<div class="accept-employee-form">
	<?php Pjax::begin([
		'id' => 'form-save-comments',
	]) ?>
		<?php $form = ActiveForm::begin([
			'id' => 'comment-form',
			'class' => 'form-horizontal',
			'enableClientValidation' => true,
			'action' => Url::toRoute(['/comments/default/save', 'subject_id' => $subject_id]),
		])?>

		<?= $form->field($model, 'name')->textInput(['disabled' => $disabled, 'value' => $username]) ?>
		<?= $form->field($model, 'body')->widget(net\frenzel\textareaautosize\yii2textareaautosize::classname(), []); ?>
		<?php
			if (Yii::$app->user->isGuest) {
				echo $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(), [
					'options' => ['class' => 'form-control captcha-input'],
					'captchaAction' => '/comments/default/captcha',
					'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
				]);
				echo Html::button(Yii::t('app', 'Refresh captcha'), ['id' => 'refresh-captcha']);
			}
		?>

		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Create comment'), ['class' => 'btn btn-raised btn-primary', 'id' => 'submit-comment']) ?>
			<?= Html::a(Yii::t('app', 'Cancel'), '#', ['class' => 'form-close btn btn-raised btn-default']) ?>
		</div>
		<?= $form->field($model, 'group_id')->hiddenInput(['value' => '', 'id' => 'group_id'])->label(false) ?>
		<?= $form->field($model, 'global_group_id')->hiddenInput(['value' => '', 'id' => 'global_group_id'])->label(false) ?>
		<?= $form->field($model, 'parent_id')->hiddenInput(['value' => '', 'id' => 'parent_id'])->label(false) ?>

		<?php ActiveForm::end(); ?>
	<?php Pjax::end(); ?>
</div>
