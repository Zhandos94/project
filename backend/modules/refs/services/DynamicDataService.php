<?php
/**
 * Created by BADI.
 * DateTime: 21.12.2016 22:26
 */

namespace backend\modules\refs\services;


use backend\modules\refs\models\RefDynamicTableData;

class DynamicDataService
{

    public function getDynamicModels($groupId = null)
    {
        return RefDynamicTableData::findAll(['group_id' => $groupId]);
    }
}