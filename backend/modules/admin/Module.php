<?php

namespace backend\modules\admin;
use yii\helpers\ArrayHelper;
/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';



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


