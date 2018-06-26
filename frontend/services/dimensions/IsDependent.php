<?php
/**
 * Created by BADI.
 * DateTime: 09.01.2017 16:31
 */

namespace frontend\services\dimensions;


use backend\modules\dimensions\models\DimData;
use backend\modules\dimensions\models\DimRelations;
use common\interfaces\Executable;
use Yii;

class IsDependent implements Executable
{

    /* @var $_dimId integer */
    private $_dimId;

    public function __construct($dimId)
    {
        if (is_int($dimId)) {
            $this->_dimId = $dimId;
        }
    }


    /**
     * @return mixed
    */
    public function execute()
    {
        $isDependent = true;
        /* @var $relation DimRelations */
        $relation = DimRelations::find()->where(['child_dim_id' => $this->_dimId])->one();
        if ($relation === null) {
            $isDependent = false;
        } else {
            $dimension = DimData::findOne($relation->parent_dim_id);
            if ($dimension !== null) {
                $isDependent = $relation->parent_dim_id;
            } else {
                Yii::warning('cannot find parent dimension, id = ' . $relation->parent_dim_id . ' child dim id = '
                    . $this->_dimId,'dim_relations');
            }
        }
        return $isDependent;
    }
}