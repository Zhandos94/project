<?php
/**
 * Created by BADI.
 * DateTime: 18.12.2016 14:29
 */

namespace frontend\services\dimensions;


use backend\modules\dimensions\models\DimData;
use common\models\LotAttributeVal;
use common\interfaces\HasDimension;

class SaveLotAttrs
{

    /* @var $_lot HasDimension */
    private $_lot;

    /* @var $_dim DimData */
    private $_dim;

    private $_val;

    public function __construct(HasDimension $lot, DimData $dimension, $value)
    {
//        if (trim($value) != '') {
            $this->_val = $value;
            $this->_lot = $lot;
            $this->_dim = $dimension;
//        }
    }

    public function execute()
    {
        $save = true;
        $lotAttrVal = LotAttributeVal::find()->where([
            'auc_id' => $this->_lot->getAucId(),
            'lot_type_id' => $this->_lot->getLotTypeId(),
            'dim_id' => $this->_dim->id,
            'lot_id' => $this->_lot->getLotId(),
        ])->one();
        if ($lotAttrVal === null) {
            $lotAttrVal = new LotAttributeVal();
            $lotAttrVal->lot_type_id = $this->_lot->getLotTypeId();
            $lotAttrVal->auc_id = $this->_lot->getAucId();
            $lotAttrVal->lot_id = $this->_lot->getLotId();
            $lotAttrVal->dim_id = $this->_dim->id;
        }
        switch ($this->_dim->dataType->code) {
            case 'string':
            case 'text':
                $lotAttrVal->text = $this->_val;
                break;
            case 'datetime':
                $lotAttrVal->date = $this->_val;
                break;
            default: //numeric, ref, checkbox
                $lotAttrVal->numeric = preg_replace('/\s+/', '',$this->_val);
        }
        if (!$lotAttrVal->save(false)) {
            $data = [
                'error' => $lotAttrVal->getErrors(),
                'dim_id' => $this->_dim->id,
                'lot_id' => $this->_lot->getLotId(),
                'value' => $this->_val,
            ];
            \Yii::error($data, 'lot_attr_error');
            $save = false;
        }
        return $save;
    }
}