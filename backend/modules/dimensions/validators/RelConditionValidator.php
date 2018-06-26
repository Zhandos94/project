<?php
/**
 * Created by BADI.
 * DateTime: 13.01.2017 10:00
 */

namespace backend\modules\dimensions\validators;


use backend\modules\dimensions\models\DimData;
use backend\modules\dimensions\models\DimRelations;
use backend\modules\refs\models\MetaTable;
use common\interfaces\HasRelation;
use Yii;
use yii\db\Exception;
use yii\validators\Validator;

class RelConditionValidator extends Validator
{

    /**
     * @param $model DimRelations
     * @param $attribute string
     */
    public function validateAttribute($model, $attribute)
    {
        /* @var $childDim DimData */
        $childDim = DimData::find()->where(['id' => $model->child_dim_id])->one();
        $orderBy = null;
        if ($childDim->sort_by) {
            $sort = $childDim->sort_by;
            $orderBy = "order by {$sort}";
        }

        /* @var $chRefMeta MetaTable */
        $chRefMeta = MetaTable::find()->where(['id' => $childDim->ref_id])->one();
        if ($chRefMeta !== null) {
            /* @var $chRef HasRelation */
            $chRef = new $chRefMeta->model_name;
            $name = $chRef->getNameColumn();
            $id = $chRef->getIdColumn();
            $tableName = $chRefMeta->table_name;
            $condition = $model->$attribute;
            $condition = preg_replace('/\{\{.*?\}\}/', 0, $condition);
            if (!$model->extra_toggle) {
                try {
                    Yii::$app->db->createCommand(
                        "select {$id} as id, {$name} as name from {$tableName} where {$condition} {$orderBy}"
                    )->queryAll();
                } catch (Exception $e) {
                    $this->addError($model, $attribute, Yii::t('dim', 'It is bad SQL command'));
                }
            }
        }
    }
}