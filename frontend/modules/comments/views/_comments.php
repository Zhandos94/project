<script>
	var subject_id = <?= $subject_id; ?>;
	var group_id = <?= $group_id; ?>;
	var comment_group_id = <?= \Yii::$app->getModule('comments')->params['comment_group']; ?>;
	var isGuest = false;
</script>

<?php if(Yii::$app->user->isGuest){  ?>
  <script>
	isGuest = true;
  </script>
<?php } ?>

<?php
use frontend\assets\CommentAsset;
use yii\bootstrap\Modal;

CommentAsset::register($this);

$script = <<< JS
var comments = new Comments();
var paginator = new Paginator();

$.when(comments.getAjaxRequest()).then(
	function (response) {
		if (response) {
			var result = JSON.parse(response);
			if (Array.isArray(result)) {
				paginator.setRecords(result);
				paginator.pageRender();
			}
		}
	},
	function (error) {
		console.log(error.statusText); // текст ошибки
	}
);

JS;
$this->registerJs($script, yii\web\View::POS_END);
?>

<div id="comments">
	<?= '<button
		class="button-comment btn btn-raised btn-primary"
		data-subject-id="'. $subject_id .'"
		data-group-id="' . $group_id . '"
		data-global-group-id="'. $group_id .'">'. Yii::t('app', 'Comment') .'</button>';
	?>
</div>



<div class="comment-form panel" hidden="true">
	<?= $this->render('@frontend/modules/comments/views/_form', [
		'subject_id' => $subject_id
	]) ?>
</div>

<?php
Modal::begin([
	'header' => '<h3>' . Yii::t('app', 'Reglament') . '</h3>',
	'id' => 'modal',
]);

echo '<div id="modalContent"><h4>' . Yii::t('app', 'Rules') . '</h4></div>';
echo '<button type="button" class="btn btn-raised btn-info" data-dismiss="modal">' . Yii::t('app', 'Confirm') . '</button>';
Modal::end();
?>
