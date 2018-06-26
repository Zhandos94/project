<?php

namespace common\models\refs;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ref_banks".
 *
 * @property string $bik
 * @property integer $code
 */
class RefBanks extends References
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_banks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['code'], 'integer'],
            [['bik'], 'string', 'max' => 255],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(),[
            'bik' => Yii::t('app', 'Bik'),
            'code' => Yii::t('app', 'Code'),
        ]);
    }
}
