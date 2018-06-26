<?php
$params = array_merge(
	require(__DIR__ . '/../../common/config/params.php'),
	require(__DIR__ . '/../../common/config/params-local.php'),
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
	'id' => 'app-console',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'controllerNamespace' => 'console\controllers',
	'components' => [
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
		],

		'log' => [
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
	],

	'controllerMap' => [
		'migrate' => [
			'class' => 'yii\console\controllers\MigrateController',
			'migrationNamespaces' => [
				'backend\modules\translate\migrations',
				'backend\modules\helps\migrations',
                'backend\modules\dimensions\migrations',
                'backend\modules\refs\migrations',
                'backend\modules\admin\migrations',
                'backend\modules\logs\migrations',
                'backend\modules\document\migrations',
			],
		],
	],


	'params' => $params,
];
