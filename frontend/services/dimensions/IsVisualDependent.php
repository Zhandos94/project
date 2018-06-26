<?php
/**
 * Created by BADI.
 * DateTime: 19.01.2017 18:40
 */

namespace frontend\services\dimensions;


use backend\modules\dimensions\models\DimData;
use backend\modules\dimensions\models\DimVisibilitySettings;
use common\interfaces\Executable;
use Yii;

class IsVisualDependent implements Executable
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
        /* @var $relation DimVisibilitySettings */
        $relation = DimVisibilitySettings::find()->where(['child_dim_id' => $this->_dimId])->one();
        if ($relation === null) {
            $isDependent = false;
        } else {
            $dimension = DimData::findOne($relation->parent_dim_id);
            if ($dimension !== null) {
                $isDependent = $relation->parent_dim_id;
            } else {
                Yii::warning('cannot find parent dimension, id = ' . $relation->parent_dim_id . ' child dim id = '
                    . $this->_dimId, 'dim_relations');
            }
        }
        return $isDependent;
    }
}