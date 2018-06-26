<?php
/**
 * Created by BADI.
 * DateTime: 09.12.2016 18:23
 */

namespace frontend\validators;

use backend\modules\dimensions\models\DimData;


/**
 * @property string $attribute
 * @property DimData $dimension
 * @property string $jsId
 */
abstract class AttributeValueValidator
{
    protected $attribute;
    protected $dimension;
    protected $jsId;

    /**
     * @param $dimension DimData
     * @param $attribute string
     */
    public function __construct(DimData $dimension, $attribute)
    {
        if($dimension !== null && trim($attribute) != ''){
            $this->dimension = $dimension;
            $this->attribute = $attribute;
            $this->jsId = 'lot-dim-' . $dimension->code;
        }
    }

    protected function writeLog($validator){
        \Yii::warning(print_r([
            'userId' => \Yii::$app->user->id,
            'dimId' => $this->dimension->id,
            'value' => $this->attribute,
            'validator' => $validator,
        ], true), 'dim_validators');
    }
}