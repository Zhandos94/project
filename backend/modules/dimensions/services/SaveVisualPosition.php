<?php
/**
 * Created by BADI.
 * DateTime: 18.01.2017 16:44
 */

namespace backend\modules\dimensions\services;


use backend\modules\dimensions\models\DimData;
use backend\modules\dimensions\models\LotDimensions;
use Yii;

class SaveVisualPosition
{
    /* @var $lotTypeId integer */
    protected $lotTypeId;

    /* @var $post array data from $_POST */
    protected $post = [];

    protected $errorTxt;


    public function __construct($lotTypeId)
    {
        if (preg_match('/\d+/', $lotTypeId)) {
            $this->lotTypeId = $lotTypeId;
            $this->post = Yii::$app->request->post('dimensions');
        } else {
            $type = gettype($lotTypeId);
            $this->errorTxt = "not integer lotTypeId, given {$type} - " . print_r($lotTypeId, true);
            $this->writeError();
        }
    }


    public function execute()
    {
        $result = $this->save();
        return $result;
    }

    /**
     * @return boolean
     */
    private function save()
    {
        $success = false;
        foreach ($this->post as $dimCode => $data) {
            /* @var $dimension DimData */
            $dimension = DimData::find()->where(['code' => $dimCode])->one();
            if ($dimension !== null) {
                $dimId = $dimension->id;

                /* @var $lotDim LotDimensions */
                $lotDim = LotDimensions::find()->where(['lot_type_id' => $this->lotTypeId, 'dim_id' => $dimId])->one();
                if ($lotDim !== null) {
                    $lotDim->row_num = $data['row_num'];
                    $lotDim->col_count = $data['col_count'];
                    $lotDim->order_in_row = $data['order_in_row'];
                    if (!$lotDim->save()) {
                        $this->errorTxt = $lotDim->getErrors();
                        $this->writeError();
                    }
                }
            }
        }
        if ($this->errorTxt === null) {
            $success = true;
        }
        return $success;
    }

    protected function writeError()
    {
        $data = [
            'post[dimensions]' => $this->post,
            'lotTypeId' => $this->lotTypeId,
            'message' => print_r($this->errorTxt, true)
        ];
        Yii::error($data, 'dim_visual_pos');
    }
}