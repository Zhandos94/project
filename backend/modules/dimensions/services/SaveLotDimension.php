<?php
/**
 * Created by BADI.
 * DateTime: 30.11.2016 16:10
 */

namespace backend\modules\dimensions\services;


use backend\modules\dimensions\models\DimData;
use backend\modules\dimensions\models\LotDimensions;
use common\models\refs\RefLotTypes;

class SaveLotDimension
{

    private $dimId;
    private $lotTypeId;

    /**
     * @param DimData $dimension
     * @param integer $lotTypeId
     */
    public function __construct(DimData $dimension, $lotTypeId)
    {
        if ($dimension !== null && (($lotType = RefLotTypes::findOne($lotTypeId)) !== null)) {
            $this->dimId = $dimension->id;
            $this->lotTypeId = $lotTypeId;
        }
    }

    public function execute()
    {
        $success = true;
        $existingLotDim = LotDimensions::find()->where(['dim_id' => $this->dimId, 'lot_type_id' => $this->lotTypeId])->one();
        if ($existingLotDim === null) {
            $lotDimension = new LotDimensions();
            $lotDimension->dim_id = $this->dimId;
            $lotDimension->lot_type_id = $this->lotTypeId;
            if (!$lotDimension->save()) {
                \Yii::error($lotDimension->getErrors(), 'lot_dim');
                $success = false;
            }
        }
        return $success;
    }
}