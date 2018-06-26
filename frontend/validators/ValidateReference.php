<?php
/**
 * Created by BADI.
 * DateTime: 09.12.2016 19:19
 */

namespace frontend\validators;


use backend\modules\dimensions\models\DimData;
use backend\modules\refs\models\MetaTable;
use backend\modules\refs\models\RefDynamicTableData;
use yii\db\ActiveRecord;

class ValidateReference extends AttributeValueValidator
{
    private function className()
    {
        return 'ValidateReference';
    }

    public function execute()
    {
//        \Yii::error($this->attribute, 'lot_attr_error');
        $validate = [];
        $validate['message'] = \Yii::t('dim', '{attribute} value is incorrect',
            ['attribute' => \Yii::t('dim', $this->dimension->name)]);
        $validate['id'] = $this->jsId;
        if (is_numeric($this->attribute)) {
            if ($this->checkRef()) {
                $validate = true;
            }
        } else {
//            \Yii::error('badi test test badi', 'lot_attr_error');
            $this->writeLog($this->className());
        }
        return $validate;
    }

    private function checkRef()
    {
        $check = true;
        $refId = $this->dimension->ref_id;
//        \Yii::error($refId, 'lot_attr_error');
        if ($refId == DimData::DYNAMIC_REF) {
//            \Yii::error('bugqwdwqdqd', 'lot_attr_error');
            $groupId = $this->dimension->ref_group_id;
            if (RefDynamicTableData::find()->where(['id' => $this->attribute, 'group_id' => $groupId])->one() === null) {
//                \Yii::error('fail reference', 'lot_attr_error');
                $check = false;
            } else {
//                \Yii::error('bug', 'lot_attr_error');
            }
        } else {
            $modelName = MetaTable::findOne($refId)->model_name;
            /* @var $model ActiveRecord */
            $model = new $modelName;
            $primKey = $model::primaryKey()[0];
            if ($model::find()->where([$primKey => $this->attribute])->one() === null) {
                $this->writeLog($this->className());
                $check = false;
            }
        }
//        \Yii::error($check, 'lot_attr_error');
        return $check;
    }
}