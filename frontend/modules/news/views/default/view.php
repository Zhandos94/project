<div class="panel">
	<div class="panel-body">
		<?= $content ?>
		<?= '<hr>' ?>
		<?php
		$group_id = Yii::$app->getModule('comments')->params['news_group'];
		if (file_exists(Yii::getAlias('@frontend/modules/comments/views/_comments') . '.php')) {
			echo $this->render('@frontend/modules/comments/views/_comments', [
				'subject_id' => $id,
				'group_id' => $group_id,
			]);
		}
		?>
	</div>
</div>
