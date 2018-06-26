<?php
$params = array_merge(
	require(__DIR__ . '/../../common/config/params.php'),
	require(__DIR__ . '/../../common/config/params-local.php'),
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
	'language' => 'ru-RU',
	'id' => 'app-frontend',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'controllerNamespace' => 'frontend\controllers',
	'modules' => [
		/*'sliderrevolution' => [
			'class' => 'wadeshuler\sliderrevolution\SliderModule',
			'pluginLocation' => '@frontend/views/auto/_form.php',    // <-- path to your rs-plugin directory
		],*/
		/*'companies' => [
			'class' => 'frontend\modules\companies\ComBankReqModule',
//            'defaultRoute' => 'com-bank-req/index'
		],*/
		'news' => [
			'class' => 'frontend\modules\news\Module'
		],
		'comments' => [
			'class' => 'frontend\modules\comments\Module'
		],
		/*'refs' => [
			'class' => 'frontend\modules\refs\Module',
		],*/
		'articles' => [
			'class' => 'frontend\modules\articles\Module',
		],
		'helps' => [
			'class' => 'frontend\modules\helps\Module',
		],
		'auctions' => [
			'class' => 'frontend\modules\auctions\Module',
		],
        'document' => [
            'class' => 'frontend\modules\document\Module',
            'defaultRoute' => 'document',
        ],
	],
	'components' => [
		'formatter' => [
			'dateFormat' => 'dd-MM-yyyy',
		],
		'request' => [
			'csrfParam' => '_csrf-frontend',
		],
		'user' => [
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => true,
			'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
		],
		'session' => [
			// this is the name of the session cookie used for login on the frontend
			'name' => 'advanced-frontend',
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['info'],
					'categories' => ['article_log'],
					'logFile' => '@runtime/logs/http_articles.log',
					'logVars' => [],
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['info'],
					'categories' => ['auc_log'],
					'logFile' => '@runtime/logs/auction.log',
					'logVars' => [],
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['info'],
					'categories' => ['auc_images_log'],
					'logFile' => '@runtime/logs/auction_images.log',
					'logVars' => [],
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error'],
					'categories' => ['comment_log'],
					'logFile' => '@runtime/logs/comment.log',
					'logVars' => [],
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error'],
					'categories' => ['lot_attr_error'],
					'logFile' => '@runtime/logs/lot_attr_error.log',
					'logVars' => [],
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error'],
					'categories' => ['lot_data'],
					'logFile' => '@runtime/logs/lot_data_errors.log',
					'logVars' => [],
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error'],
					'categories' => ['auc_data'],
					'logFile' => '@runtime/logs/auc_data_errors.log',
					'logVars' => [],
				],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['document'],
                    'logFile' => '@runtime/logs/document.log',
                    'logVars' => [],
                ],
			],
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],

		'urlManager' => [
			'enableStrictParsing' => false,
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				'companies' => 'companies/com-bank-req/index',
				'company/<com_id:\d+>' => 'companies/com-additional/com-view',
				'news/<id:\d+>' => 'news/default/view',
				'articles/<id:\d+>' => 'articles/default/view',
				'articles/<slug:[\w-]+>' => 'articles/default/index',
				'news/<slug:[\w-]+>' => 'news/default/index',
			]
		],
	],
	'params' => $params,
];
