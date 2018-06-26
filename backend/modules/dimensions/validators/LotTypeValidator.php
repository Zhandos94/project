<?php
/**
 * Created by BADI.
 * DateTime: 30.11.2016 15:46
 */

namespace backend\modules\dimensions\validators;


use common\models\refs\RefLotTypes;
use Yii;
use yii\validators\Validator;

class LotTypeValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (RefLotTypes::find()->where(['id' => $model->$attribute])->one() === null) {
            $this->addError($model, $attribute, Yii::t('dim', 'This item is not exist'));
        }
    }
}