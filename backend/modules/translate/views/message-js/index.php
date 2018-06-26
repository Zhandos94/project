<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\modules\translate\models\SourceMessage;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Message Js');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="message-js-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			[
				'attribute'=> 'id',
				'header'=> 'id',
				'headerOptions' => ['style' => 'width:5%'],
			],
			'message',
			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view}',
			],
            [
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(Yii::t('app', 'Add'), ['add-message', 'id' => $model->id], ['class'=>'btn btn-success show_modal']);
                },
            ],
        ],
	]);
	?>
</div>



<?php Modal::begin([
    'options' => ['id' => 'addMessage'],
    'header' => Yii::t('app', 'Message Js')
]); ?>
<?php
$source_message = new SourceMessage();
$source_message->setScenario('saveMessage');

$form = ActiveForm::begin([
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'validationUrl' => 'valid',
]); ?>

<?= $form->field($source_message, 'kz')->textInput(['maxlength' => true])->label('KZ') ?>
<?= $form->field($source_message, 'ru')->textInput(['maxlength' => true])->label('RU') ?>
<?= $form->field($source_message, 'en')->textInput(['maxlength' => true])->label('EN') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

<?php Modal::end(); ?>


<?php
$js = <<< JS
window.onload = function () {
    var url_j;
    $( ".show_modal" ).click(function (e) {
        e.preventDefault();
        $('#addMessage').modal('show');
        url_j = $(this).attr('href');
    });
    
    $('#addMessage').submit(function (e) {
        $(this).prop('disabled', true);
        e.preventDefault();
        var formData = $('form').serialize(); 

        $.ajax({
            url: url_j,
            type: 'post',
            dataType: 'json',
            data: formData,
            success: function () {
                $('.show_modal').modal('hide');
            }
        });
    });
}
JS;
$this->registerJs($js);
?>
