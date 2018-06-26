<?php
/**
 * Created by BADI.
 * DateTime: 29.11.2016 19:37
 */

namespace common\services\dimensions;


use backend\modules\dimensions\models\DimData;
use backend\modules\dimensions\models\DimRelations;
use backend\modules\dimensions\models\LotDimensions;
use common\interfaces\HasRelation;
use common\models\LotAttributeVal;
use backend\modules\refs\models\MetaTable;
use backend\modules\refs\models\RefDynamicTableData;
use backend\modules\refs\models\RefDynamicTableName;
use common\interfaces\HasDimension;
use common\models\refs\RefDimDataTypes;
use common\models\refs\RefLotTypes;
use frontend\helpers\NumericHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * @property string[] getDimDataTypes
 */
class Get
{
    public function dimDataTypesList()
    {
        $dataTypes = RefDimDataTypes::find()->where(['disabled' => 0])->all();
        return ArrayHelper::map($dataTypes, 'id', 'name');
    }

    public function lotTypesList()
    {
        $lotTypes = RefLotTypes::find()->where(['disabled' => 0])->all();
        return ArrayHelper::map($lotTypes, 'id', 'name');
    }

    /**
     * @param $create boolean
     * @return array
     */
    public function dimCodesList($create = true)
    {
        $createCode = [9999 => Yii::t('app', 'create code of dimension')];
        if (!$create) {
            $createCode = [];
        }
        $dimensions = DimData::find()->where(['is_active' => 1])->all();
        $codes = ArrayHelper::map($dimensions, 'id', 'code');
        return ArrayHelper::merge($createCode, $codes);
    }

    /**
     * Returns list of references
     * @return string[]
     */
    public function refsList()
    {
        $refs = MetaTable::find()->all();
        $list = [];
        /* @var $ref MetaTable */
        foreach ($refs as $ref) {
            $list[$ref->id] = $ref->table_name . ' - ' . $ref->description;
        }
        return $list;
    }

    /**
     * This function for obtain of reference data
     * @param $dimension DimData
     * @return string[]
     */
    public function ref(DimData $dimension)
    {
        $refId = $dimension->ref_id;
        $refGroupId = $dimension->ref_group_id;
        $orderBy = $dimension->sort_by;
        if ($refId == DimData::DYNAMIC_REF) {
            $models = RefDynamicTableData::findAll(['group_id' => $refGroupId, 'disabled' => 0]);
            $primKey = 'id';
        } else {
            $modelName = MetaTable::findOne($refId)->model_name;
            /* @var $model ActiveRecord */
            $model = new $modelName;
            $models = $model::find()->orderBy($orderBy)->all();
            $primKey = $model::primaryKey()[0];
        }
        return ArrayHelper::map($models, $primKey, 'name');
    }

    /**
     * @param $lot HasDimension
     * @param $dimId integer
     * @return string|null
     */
    public function attrVal(HasDimension $lot, $dimId)
    {
        $value = null;
        /* @var $attrVal LotAttributeVal */
        $attrVal = LotAttributeVal::find()->where([
            'auc_id' => $lot->getAucId(),
            'lot_type_id' => $lot->getLotTypeId(),
            'dim_id' => $dimId,
            'lot_id' => $lot->getLotId(),
        ])->one();
        if ($attrVal !== null) {
            $value = $attrVal->getValue();
        }
//        var_dump($value);
        $value = $this->reformatting($value, $dimId);
//        var_dump($value);
        return $value;
    }

    public function dynamicList()
    {
        $dynamicDatas = RefDynamicTableName::findAll(['disabled' => 0]);
        return ArrayHelper::map($dynamicDatas, 'id', 'name');
    }

    public function postValues()
    {
        $model = new LotAttributeVal();
        $post = Yii::$app->request->post($model->formName());
        $data = [];
        if ($post !== null) {
            foreach ($post as $code => $value) {
                $data[] = ['id' => 'lot-dim-' . $code, 'val' => $value];
            }
        }
        return json_encode($data);
    }

    public function dependentList($parDimVal, $childDim, $parDimId)
    {
        $list = [];
        $array = [];
        if (($childDim instanceof DimData)) {
            $orderBy = null;
            if ($childDim->sort_by) {
                $sort = $childDim->sort_by;
                $orderBy = "order by {$sort}";
            }
            /* @var $relation DimRelations */
            $relation = DimRelations::find()->where([
                'parent_dim_id' => $parDimId,
                'child_dim_id' => $childDim->id
            ])->one();

            /* @var $chRefMeta MetaTable */
            $chRefMeta = MetaTable::find()->where(['id' => $childDim->ref_id])->one();
            if ($chRefMeta !== null && $relation !== null) {
                /* @var $chRef HasRelation */
                $chRef = new $chRefMeta->model_name;
                $name = $chRef->getNameColumn();
                $id = $chRef->getIdColumn();
                $tableName = $chRefMeta->table_name;
                $condition = $relation->condition;
                if (trim($parDimVal) == '') {
                    $parDimVal = 0;
                }
                $condition = preg_replace('/\{\{.*?\}\}/', $parDimVal, $condition);
                $list = Yii::$app->db->createCommand(
                    "select {$id} as id, {$name} as name from {$tableName} where {$condition} {$orderBy}"
                )->queryAll();

                if ($tableName == 'ref_kato' && $relation->extra_toggle == 1) {
                    if (
                        ($parDimVal == '750000000') ||
                        ($parDimVal == '710000000')
                    ) {
                        $list = Yii::$app->db->createCommand(
                            "select {$id} as id, {$name} as name from {$tableName}
                             where ab = (select ab from ref_kato where te={$parDimVal})
                             and ef!=00
                             and cd !=00"
                        )->queryAll();
                    } else {
                        $list = Yii::$app->db->createCommand(
                            "select {$id} as id, {$name} as name from {$tableName}
                             where ab = (select ab from ref_kato where te={$parDimVal})
                             and ef=00
                             and cd!=00 
                             and hij=000"
                        )->queryAll();
                    }
                }
            }
        }
        foreach ($list as $item) {
            $array[$item['id']] = $item['name'];
        }
        return $array;
    }

    public function reformatting($value, $dimId)
    {
        $result = null;
        if (trim($value) != '') {
            /* @var $dimension DimData */
            $dimension = DimData::find()->where(['id' => $dimId])->one();
            switch ($dimension->type_id) {
                case DimData::TYPE_NUMERIC:
                case DimData::TYPE_REF:
                case DimData::TYPE_CHECKBOX:
                    $result = NumericHelper::reformatting($value, $dimension->decimal_sym_num);
                    break;
                case DimData::TYPE_DATETIME:
                    $formatter = Yii::$app->formatter;
                    if ($dimension->with_time) {
                        $result = $formatter->asDatetime($value, 'php:Y-m-d h:i');
                    } else {
                        $result = $formatter->asDate($value, 'php:Y-m-d');
                    }
                    break;
                default:
                    $result = $value;
            }
        }
        return $result;
    }

    /**
     * @param $lotTypeId integer
     * @return LotDimensions[] ordered by number of row
     */
    public function lotDims($lotTypeId)
    {
        $lotDims = LotDimensions::find()->where(['lot_type_id' => $lotTypeId])
            ->orderBy('row_num, order_in_row')->all();
        $array = [];
        /* @var $lotDim LotDimensions */
        foreach ($lotDims as $lotDim){
            $array[$lotDim->row_num][] = $lotDim;
        }
        return $array;
    }
}