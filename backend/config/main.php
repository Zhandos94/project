<?php
$params = array_merge(
	require(__DIR__ . '/../../common/config/params.php'),
	require(__DIR__ . '/../../common/config/params-local.php'),
	require(__DIR__ . '/params.php'),
	require(__DIR__ . '/params-local.php')
);

return [
	'id' => 'app-backend',
	'basePath' => dirname(__DIR__),
	'controllerNamespace' => 'backend\controllers',
	'bootstrap' => ['log'],
	'modules' => [
		'translate' => [
			'class' => 'backend\modules\translate\Module',
			'defaultRoute' => 'source-message'
		],
		'gridview' =>  [
			'class' => '\kartik\grid\Module'
		],
		'helps' => [
			'class' => 'backend\modules\helps\Module',
		],
		'admin' => [
			'class' => 'mdm\admin\Module',
			'layout' => 'left-menu', // avaliable value 'left-menu', 'right-menu' and 'top-menu'
			'controllerMap' => [
				'assignment' => [
					'class' => 'mdm\admin\controllers\AssignmentController',
					'userClassName' => 'common\models\User',
					'idField' => 'user_id'
				]
			],
			'menus' => [
				'assignment' => [
					'label' => 'Grand Access' // change label
				],
//                'route' => null, // disable menu
			],
		],
        'dimensions' => [
            'class' => 'backend\modules\dimensions\Module',
        ],
        'logs' => [
            'class' => 'backend\modules\logs\Module',
        ],
        'refs' => [
            'class' => 'backend\modules\refs\Module',
        ],
        'myadmin' => [
            'class' => 'backend\modules\admin\Module',
            'layout' => 'left-menu',
            'defaultRoute' => 'user',

        ],
        'document' => [
            'class' => 'backend\modules\document\Module',
        ],
        'pages' => [
            'class' => 'backend\modules\pages\Module',
        ],
	],
	'components' => [
		'request' => [
			'csrfParam' => '_csrf-backend',
		],
		'user' => [
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => true,
			'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
		],
		'session' => [
			// this is the name of the session cookie used for login on the backend
			'name' => 'advanced-backend',
		],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
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
					'levels' => ['error'],
					'categories' => ['message_log'],
					'logFile' => '@runtime/logs/GJsMessageISM.log',
					'logVars' => [],
				],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['dim_data_log'],
                    'logFile' => '@runtime/logs/DimData.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['lot_dim'],
                    'logFile' => '@runtime/logs/lot_dimension.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['dim_data'],
                    'logFile' => '@runtime/logs/dim_data.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['lot_attr_rules'],
                    'logFile' => '@runtime/logs/lot_attr_rules.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'categories' => ['dim_validators'],
                    'logFile' => '@runtime/logs/dim_validators.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['ref_dynamic'],
                    'logFile' => '@runtime/logs/ref_dynamic_data.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['log_user'],
                    'logFile' => '@runtime/logs/log_user.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['auth_item'],
                    'logFile' => '@runtime/logs/auth_item.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['auth_assignment'],
                    'logFile' => '@runtime/logs/auth_assignment.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['route'],
                    'logFile' => '@runtime/logs/route.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['document'],
                    'logFile' => '@runtime/logs/document.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['pages'],
                    'logFile' => '@runtime/logs/pages.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['pages_errors'],
                    'logFile' => '@runtime/logs/pages_errors.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'categories' => ['pages_warnings'],
                    'logFile' => '@runtime/logs/pages_warnings.log',
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

			]
		],
// 		'i18n' => Zelenin\yii\modules\I18n\Module::className(),
// 		'admin' => [
// 			'class' => 'mdm\admin\Module',
// 			'layout' => 'left-menu', // avaliable value 'left-menu', 'right-menu' and 'top-menu'
// 			'controllerMap' => [
// 				'assignment' => [
// 					'class' => 'mdm\admin\controllers\AssignmentController',
// 					'userClassName' => 'common\models\User',
// 					'idField' => 'user_id'
// 				]
// 			],
// 			'menus' => [
// 				'assignment' => [
// 					'label' => 'Grand Access' // change label
// 				],
// //                'route' => null, // disable menu
// 			],
// 		],
	],

	'params' => $params,
];
