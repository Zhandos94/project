<?php

namespace backend\modules\translate\controllers;

use yii\web\Controller;
/**
 * Default controller for the `translate` module
 */
class DefaultController extends Controller
{
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex()
	{
		// $wr = new WriteToJsService();
		// $wr->execute();
		return $this->render('index');
	}
}
