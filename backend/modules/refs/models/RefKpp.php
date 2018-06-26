<?php

namespace backend\modules\refs\models;

use common\models\refs\References;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ref_kpp".
 */
class RefKpp extends References
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_kpp';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(),[
            'image' => 'Image'
        ]);
    }

}
