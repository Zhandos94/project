<?php

namespace backend\modules\refs;

/**
 * refs module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\refs\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->params['locked'] = 1;

        // custom initialization code goes here
    }
}
