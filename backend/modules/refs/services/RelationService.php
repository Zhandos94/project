<?php
/**
 * Created by BADI.
 * DateTime: 05.01.2017 18:45
 */

namespace backend\modules\refs\services;


use backend\modules\refs\models\MetaTable;
use backend\modules\refs\models\RefRelationsColumns;

class RelationService
{

    /**
     * @param $relId integer relation_id
     * @return array RefRelationsColumns[]
     */
    public function getColumnModels($relId = null)
    {
        return RefRelationsColumns::findAll(['relation_id' => $relId]);
    }

    /**
     * @param $tblId integer
     * @return string[] columns of table
     */
    public function getColumnList($tblId)
    {
        $usableList = [];
        $columns = [];
        $ref = MetaTable::findOne($tblId);
        if ($ref !== null) {
            $tableName = $ref->table_name;
            $columns = RefService::getColumns($tableName);
        }
        foreach ($columns as $column) {
            $usableList[$column] = $column;
        }
        return $usableList;
    }
}