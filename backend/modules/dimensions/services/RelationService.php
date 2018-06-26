<?php
/**
 * Created by BADI.
 * DateTime: 09.01.2017 17:17
 */

namespace backend\modules\dimensions\services;


use backend\modules\dimensions\models\DimData;
use yii\helpers\ArrayHelper;

class RelationService
{
    public function getRefDimensions($all = false)
    {
        $dimensions = DimData::find()->where(['is_active' => 1]);
        if (!$all) {
            $dimensions->andFilterWhere(['type_id' => DimData::TYPE_REF]);
        }
        $dimensions = $dimensions->all();
        return ArrayHelper::map($dimensions, 'id', 'code');
    }
}