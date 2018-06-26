<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
	public function actionInit()
	{
		$auth = Yii::$app->authManager;

		$createHint = $auth->createPermission('createHint');
		$createHint->description = 'Create a hint';
		$auth->add($createHint);

		$hint_editor = $auth->createRole('hint_editor');
		$auth->add($hint_editor);
		$auth->addChild($hint_editor, $createHint);

		$auth->assign($hint_editor, 1);

	}
}
