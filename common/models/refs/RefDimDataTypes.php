<?php

namespace common\models\refs;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ref_dim_data_types".
 * @property string $code
 */
class RefDimDataTypes extends References
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_dim_data_types';
    }

    /**
     * @inheritdoc
    */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),[
            [['code'], 'string', 'max' => 255],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'code' => Yii::t('app', 'Code'),
        ]);
    }
}
