<?php

namespace frontend\modules\articles;

/**
 * articles module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\articles\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        \Yii::configure($this, require(__DIR__ . '/config.php'));
        // custom initialization code goes here
    }
}
