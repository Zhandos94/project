<?php
/**
 * Created by BADI.
 * DateTime: 12.01.2017 10:04
 */

namespace backend\modules\dimensions\services;


use backend\modules\refs\models\MetaTable;
use backend\modules\refs\services\RefService;

class DimGenService
{

    public function getRefColumns($id)
    {
        $columns = [];
        /* @var $meta MetaTable */
        $meta = MetaTable::find()->where(['id' => $id])->one();
        if ($meta !== null) {
            $columns = RefService::getColumns($meta->table_name);
        }
        return $columns;
    }
}