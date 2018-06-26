<?php

namespace frontend\modules\helps;

use yii\helpers\ArrayHelper;

/**
 * help module definition class
 */
class Module extends \yii\base\Module
{
	/**
	 * @inheritdoc
	 */
	public $controllerNamespace = 'frontend\modules\helps\controllers';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
	    parent::init();

        \Yii::configure($this,
            require(__DIR__ . '/config.php')

        );
        return  $this->params['help_url'] = '/helps';
	}
}
