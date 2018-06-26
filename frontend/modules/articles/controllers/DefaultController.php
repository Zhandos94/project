<?php

namespace frontend\modules\articles\controllers;

use yii;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\modules\comments\models\CommentForm;
use frontend\services\UserService;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use common\services\GetIntColumn;

/**
 * Default controller for the `articles` module
 */
class DefaultController extends Controller
{
	/**
	 * Renders the index view for the module
	 * @param $slug string
	 * @throws NotFoundHttpException
	 * @return string
	 */
	public function actionIndex($slug = null)
	{
		$_params = \Yii::$app->controller->module->params;
		$hash = $this->generateHash();
		$url = $_params['url'] . 'default/index';
		//Yii::$app->language = 'kz-KZ';
		$lang = substr(Yii::$app->language, 0, 2);
		$data = [
			'lang' => $lang,
			'hash' => $hash,
			'client_ip' => Yii::$app->request->userIP,
		];
		if ($slug !== null) {
			$data['slug'] = $slug;
		}
		$client = new Client();
		$response = $client->createRequest()->setMethod('get')->setUrl($url)->setData($data)
			->setOptions([
				'userAgent' => Yii::$app->request->userAgent
			])->send();



		if ($response->isOk) {
			Yii::$app->view->title = Yii::t('seo', 'articles description title');
			Yii::$app->view->registerMetaTag([
				'name' => 'description',
				'content' => Yii::t('seo', 'articles description meta')
			]);
			return $this->render('_page', [
				'content' => $response->content
			]);
		} else {
			Yii::info($response->getStatusCode() . "\n" . print_r($client->createRequest()->setMethod('get')->setUrl($url)
					->setData($data), true), 'article_log');
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionView($id)
	{
		$hash = $this->generateHash();
		$_params = \Yii::$app->controller->module->params;
		$data = [
			'id' => $id,
			'hash' => $hash,
			'client_ip' => Yii::$app->request->userIP,
		];
		$url = $_params['url'] . 'default/view';
		$client = new Client();
		$response = $client->createRequest()->setMethod('get')->setUrl($url)->setData($data)
			->setOptions([
				'userAgent' => Yii::$app->request->userAgent
			])->send();
		if ($response->isOk) {
			$page = json_decode($response->content);
			Yii::$app->view->title = $page->title;
			foreach ($page->meta as $tag) {
				Yii::$app->view->registerMetaTag([
					'name' => $tag->name,
					'content' => $tag->content,
				]);
			}
			return $this->render('view', [
				'content' => $page->content,
				'id' => $id
			]);
		} else {
			Yii::info($response->getStatusCode() . "\n" . print_r($client->createRequest()->setMethod('get')->setUrl($url)
					->setData($data), true), 'article_log');
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	private function generateHash()
	{
		$hash = (new GetIntColumn('hash'))->execute();
		return $hash;
	}
}
