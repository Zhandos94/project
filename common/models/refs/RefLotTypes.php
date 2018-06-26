<?php

namespace common\models\refs;

use backend\modules\dimensions\models\LotDimensions;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ref_lot_types".
 *
 * @property string $code
 * @property integer $dimensionCount
 */
class RefLotTypes extends References
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_lot_types';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
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
            'dimensionCount' => Yii::t('app', 'Count of Dimensions')
        ]);
    }

    public function getDimensionCount()
    {
        return LotDimensions::find()->where(['lot_type_id' => $this->id])->count();
    }
}
