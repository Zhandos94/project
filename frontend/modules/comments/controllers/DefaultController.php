<?php

namespace frontend\modules\comments\controllers;

use yii\web\Controller;
use Yii;
use frontend\modules\comments\components\CommentService;
use frontend\modules\comments\models\CommentForm;
use yii\web\Response;
use common\modules\translate\services\WriteToJsService;

/**
 *
 */
class DefaultController extends Controller
{
	/**
	 * [actions description]
	 * @return array
	 */
	 public function actions()
	 {
		 return [
			 'error' => [
				'class' => 'yii\web\ErrorAction',
			 ],
			 'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,

			 ],
		 ];
	 }
	/**
	 * [actionSave description]
	 * @param  integer $subject_id
	 * @return mixed
	 */
	public function actionSave($subject_id)
	{
		$model = new CommentForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if (CommentService::customValidate($model)) {
				$response = CommentService::responseForSave($subject_id, $model);
				if ($response->isOk) {
					// return $response;
					$result = CommentService::saveComment($response->content);
				} else {
					Yii::error($response->content, 'comment_log');
				}
			} else {
				Yii::error('custom validate - regexp for script, href', 'comment_log');
			}
		}
		return $result;
	}

	/**
	 * [actionGetComments description]
	 * @param  integer	 $subject_id
	 * @param  integer $global_group_id
	 * @return string
	 */
	public function actionGetComments($subject_id, $global_group_id)
	{
		// $wr = new WriteToJsService();
		// $wr->execute();
		$response = CommentService::responseForGet($subject_id, $global_group_id);
		if ($response->isOk) {
			return $response->content;
		} else {

			//write to logs

			return json_encode('error');
		}
	}

	/**
	 * [actoinLike description]
	 * @return json
	 */
	public function actionLike()
	{
		//return true;
		Yii::$app->response->format = Response::FORMAT_JSON;
		$comment_id = Yii::$app->request->post('comment_id');
		$status = Yii::$app->request->post('status');
		$response = CommentService::likeComment($comment_id, $status);
		//return $status;
		if ($response->isOk) {
			return $response->content;
		}
	}

}

?>
