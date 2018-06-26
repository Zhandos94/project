<?php

namespace frontend\modules\comments\components;

use Yii;
use frontend\services\UserService;
use yii\httpclient\Client;
use yii\httpclient\Response;
use common\services\GetIntColumn;
use frontend\modules\comments\models\CommentForm;

/**
 *
 */
class CommentService
{
	/**
	 * [response description]
	 * @param  string $url
	 * @param  integer $subject_id
	 * @param  CommentForm $model
	 * @return Response
	 */
	public static function responseForSave($subject_id, $model)
	{
		$url = self::getUrl() . 'default/record-comment';
		$client = new Client();
		$data = self::getQueryDataSave($subject_id, $model);
		$response = $client->createRequest()
			->setMethod('post')
			->setUrl($url)
			->setData($data)
			->setOptions(['userAgent' => Yii::$app->request->userAgent])
			->send();
		return $response;
	}

	/**
	 * [responseGet description]
	 * @param  integer $subject_id
	 * @param  integer $global_group_id
	 * @return Response
	 */
	public static function responseForGet($subject_id, $global_group_id)
	{
		$url = self::getUrl() . 'default/view';
		$client = new Client();
		$data = self::getQueryDataGet($subject_id, $global_group_id);
		$response = $client->createRequest()
			->setMethod('get')
			->setUrl($url)
			->setData($data)
			->setOptions(['userAgent' => Yii::$app->request->userAgent])
			->send();
		return $response;
	}

	/**
	 * [getResponseSave description]
	 * @param  string $responseContent
	 * @return mixed
	 */
	public static function saveComment($responseContent)
	{
		// return json_decode($responseContent);
		$error_codes = Yii::$app->controller->module->params['error_codes'];
		$content = (array) json_decode($responseContent);
		if (is_array($content)) {
			if (in_array('ok', $content)) {
				$result = json_encode($content);
			} else if (in_array('cn_e006', $content)) {
				$result = json_encode($content);
			} else {
				Yii::error($error_codes[$content['code']], 'comment_log');
				$result = json_encode($content['code']);
			}
		} else {
			Yii::error('unknown error', 'comment_log');
		}
		return $result;
	}

	/**
	 * [likeComment description]
	 * @param  integer $comment_id
	 * @param  integer $status
	 * @return Response
	 */
	public static function likeComment($comment_id, $status)
	{
		$data = self::getQueryDataLike($comment_id, $status);
		$url = self::getUrl() . 'default/like';
		$client = new Client();
		$response = $client->createRequest()
			->setMethod('post')
			->setUrl($url)
			->setData($data)
			->setOptions(['userAgent' => Yii::$app->request->userAgent])
			->send();
		return $response;
	}

	/**
	 * [getUrl description]
	 * @return string
	 */
	private static function getUrl()
	{
		return Yii::$app->controller->module->params['comment_url'];
	}

	/**
	 * [getQueryDataSave description]
	 * @param  integer $subject_id
	 * @param  CommentForm $model
	 * @return array
	 */
	private static function getQueryDataSave($subject_id, $model)
	{

		$data = [
			'comment' => [
				'subject_id' => $subject_id,
				'global_group_id' => $model->global_group_id,
				'group_id' => $model->group_id,
				'parent_id'	=> $model->parent_id,
				'user_id' => self::getUserId(),
				// 'nickname' =>  self::getUserNickname($model),
				// 'body' => $model->body,
				'nickname' =>  htmlspecialchars(self::getUserNickname($model), ENT_QUOTES),
				'body' => htmlspecialchars($model->body, ENT_QUOTES),
				'system_id' => self::systemId(),
			],
			'hash' => self::generateHash(),
			'client_ip' => Yii::$app->request->userIP,
		];
		return $data;
	}

	/**
	 * [getQueryDataGet description]
	 * @param  integer $subject_id
	 * @param  integer $global_group_id
	 * @return array
	 */
	private static function getQueryDataGet($subject_id, $global_group_id)
	{
		$data = [
			'subject_id' => $subject_id,
			'global_group_id' => $global_group_id,
			'hash' => self::generateHash(),
			'client_ip' => Yii::$app->request->userIP,
		];
		return $data;
	}

	/**
	 * [getQueryDataLike description]
	 * @param  integer $comment_id
	 * @param  integer $status
	 * @return array
	 */
	private static function getQueryDataLike($comment_id, $status)
	{
		$data = [
			'comment_id' => $comment_id,
			'status' => $status,
			'user_id' => self::getUserId(),
		];
		return $data;
	}

	/**
	 * [getUserId description]
	 * @return integer
	 */
	private static function getUserId()
	{
		if (Yii::$app->user->isGuest) {
			$userId = 0;
		} else {
			$userId = Yii::$app->user->identity->id;
		}
		return $userId;
	}

	/**
	 * [getUserNickname description]
	 * @param  CommentForm $model
	 * @return string
	 */
	private static function getUserNickname($model)
	{
		if (Yii::$app->user->isGuest) {
			$username = 'Anonym';
		} else {
			$username = UserService::getNickname();
		}
		return $username;
	}

	/**
	 * [isScript description]
	 * @param  CommentForm  $model
	 * @return boolean
	 */
	private static function isScript($model)
	{
		$patternFind = "/<script>/";
		$username = preg_match($patternFind, self::getUserNickname($model));
		$body = preg_match($patternFind, $model->body);
		if ($body || $username) {
			return true;
		}
		return false;
	}

	private static function isHref($body) {
		$patternFind = "/(href|http)/";
		$body_match = preg_match($patternFind, $body);
		if ($body_match) {
			return true;
		}
		return false;
	}

	public static function customValidate(CommentForm $model)
	{
		//return !self::isHref($model->body);
		$result = false;
		if (!self::isScript($model)) {
			if (!self::isHref($model->body)) {
				$result = true;
			}
		}
		return $result;
	}


	/**
	 * [generateHash description]
	 * @return string
	 */
	private static function generateHash()
	{
		$hash = (new GetIntColumn('hash'))->execute();
		return $hash;
	}

	/**
	 * [systemId description]
	 * @return string
	 */
	public static function systemId()
	{
	$system = (new GetIntColumn('system'))->execute();
	return $system;
	}
}

?>
