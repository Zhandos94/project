<?php

namespace frontend\modules\comments;

use yii\helpers\ArrayHelper;
/**
 * news module definition class
 */
class Module extends \yii\base\Module
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'frontend\modules\comments\controllers';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		\Yii::configure($this, ArrayHelper::merge(
			require(__DIR__ . '/config.php'),
			require(__DIR__ . '/config-local.php')
		));
	}
}
