<?php
/**
 * Created by BADI.
 * DateTime: 19.01.2017 19:14
 */

namespace frontend\services\dimensions;


use backend\modules\dimensions\models\DimVisibilitySettings;
use common\interfaces\Executable;

class IsVisible implements Executable
{

    protected $childDimId;
    protected $parDimId;
    protected $parDimVal;

    public function __construct($childDimId, $parDimId, $parDimVal)
    {
        if (is_int($childDimId) && is_int($parDimId)) {
            $this->childDimId = $childDimId;
            $this->parDimId = $parDimId;
            $this->parDimVal = trim($parDimVal);
        }
    }


    public function execute()
    {
        $visible = true;
        /* @var $visRel DimVisibilitySettings visual relation */
        $visRel = DimVisibilitySettings::find()->where(['parent_dim_id' => $this->parDimId])
            ->andWhere(['child_dim_id' => $this->childDimId])->one();
        if ($visRel !== null) {
            $array = explode(',', $visRel->condition);
            foreach ($array as $key => $item) {
                $array[$key] = trim($item);
            }
            if (!in_array($this->parDimVal, $array) || $this->parDimVal == '') {
                $visible = false;
            }
        }
        return $visible;
    }
}