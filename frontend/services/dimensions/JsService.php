<?php
/**
 * Created by BADI.
 * DateTime: 14.12.2016 13:00
 */

namespace frontend\services\dimensions;

use backend\modules\dimensions\models\DimData;
use backend\modules\dimensions\models\LotDimensions;


class JsService
{

    /**
     * @var LotDimensions[]
     */
    private $_lotDims;

    /**
     * @var DimData[]
     */
    private $_dimensions = [];

    /**
     * @param integer $lotTypeId id of common\models\refs\RefLotTypes
     */
    public function __construct($lotTypeId)
    {
        $this->_lotDims = LotDimensions::find()->where(['lot_type_id' => $lotTypeId])->all();
        /* @var $lotDim LotDimensions */
        foreach ($this->_lotDims as $lotDim) {
            $this->_dimensions[] = $lotDim->dimension;
        }
    }

    public function getNumericParams()
    {
        $params = [];
        foreach ($this->_dimensions as $dimension) {
            if ($dimension->dataType->code == 'numeric') {
                $params[] = [
                    'id' => $this->jsId($dimension),
                    'vMax' => $dimension->max_val,
                ];
            }
        }
        return json_encode($params);
    }

    public function getStringParams()
    {
        $params = [];
        foreach ($this->_dimensions as $dimension) {
            if ($dimension->dataType->code == 'string') {
                $params[] = [
                    'id' => $this->jsId($dimension),
                    'min_length' => $dimension->min_length,
                    'max_length' => $dimension->max_length,
                    'minMsg' => \Yii::t('dim', '{attribute} length must be more than {min}',
                        [
                            'attribute' => \Yii::t('dim', $dimension->name),
                            'min' => $dimension->min_length,
                        ]),
                    'maxMsg' => \Yii::t('dim', '{attribute} length must be no greater than {max}',
                        [
                            'attribute' => \Yii::t('dim', $dimension->name),
                            'max' => $dimension->max_length,
                        ])
                ];
            }
        }
        return json_encode($params);
    }

    public function getDateParams()
    {
        $params = [];
        foreach ($this->_dimensions as $dimension) {
            if ($dimension->dataType->code == 'datetime') {
                $regex = '[0-9]{4}-[0-9]{2}-[0-9]{2}';
                if ($dimension->with_time) {
                    $regex = '[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}';
                }
                $params[] = [
                    'id' => $this->jsId($dimension),
                    'regex' => $regex,
                    'message' => \Yii::t('dim', 'Incorrect value of {attribute}',
                        [
                            'attribute' => \Yii::t('dim', $dimension->name),
                        ])
                ];
            }
        }
        return json_encode($params);
    }

    public function getRelationsParams()
    {
        $list = [];
        foreach ($this->_dimensions as $key => $dimension) {
            $isDependent = new IsDependent($dimension->id);
            $parentDimId = $isDependent->execute();
            if($parentDimId !== false){
                /* @var $parentDim DimData */
                $parentDim = DimData::find()->where(['id' => $parentDimId])->one();
                if($parentDim !== null){
                    $list[$key]['child'] = $this->jsId($dimension);
                    $list[$key]['parent'] = $this->jsId($parentDim);
                }
            }
        }
        return json_encode($list);
    }

    private function jsId(DimData $dimension)
    {
        return 'lot-dim-' . $dimension->code;
    }
}