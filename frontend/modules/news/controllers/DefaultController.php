<?php

namespace frontend\modules\news\controllers;

use frontend\modules\comments\models\CommentForm;
use frontend\services\UserService;
use yii;
use yii\bootstrap\ActiveForm;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use common\services\GetIntColumn;

/**
 * Default controller for the `news` module
 */
class DefaultController extends Controller
{
	public function actionIndex($slug = null)
	{
		$hash = $this->generateHash();
		$_params = \Yii::$app->controller->module->params;
		$url = $_params['url'] . 'default/index';
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
			$content = json_decode($response->content);
			Yii::$app->view->title = Yii::t('seo', 'news description title');
			Yii::$app->view->registerMetaTag([
				'name' => 'description',
				'content' => Yii::t('seo', 'news description meta')
			]);

			return $this->render('news', [
				'content' => $content
			]);
		} else {
			Yii::info($response->getStatusCode() . "\n" . print_r($client->createRequest()->setMethod('get')->setUrl($url)
					->setData($data), true), 'article_log');
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	public function actionView($id)
	{
		$_params = \Yii::$app->controller->module->params;
		$hash = $this->generateHash();
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
