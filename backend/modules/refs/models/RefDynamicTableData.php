<?php

namespace backend\modules\refs\models;

use common\interfaces\HasRelation;
use common\models\refs\References;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ref_dynamic_data".
 *
 * @property integer $group_id
 */
class RefDynamicTableData extends References implements HasRelation
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_dynamic_table_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['group_id'], 'required'],
            [['group_id'], 'integer'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'group_id' => Yii::t('app', 'Group ID'),
        ]);
    }

    public static function saveData($group_id)
    {
        $model1 = new RefDynamicTableData();//to get formName
        $formName = $model1->formName();
        $datas = Yii::$app->request->post($formName);
        if ($datas !== null) {
            self::deleteAll(['group_id' => $group_id]);
            foreach ($datas as $value) {
                $value = trim($value);
                if (\Yii::$app->language == 'kz-KZ' || \Yii::$app->language == 'kz') {
                    $name = 'name_kz';
                } else { //if (\Yii::$app->language == 'ru-RU') {
                    $name = 'name_ru';
                }
                if ($value != '') {
                    $model = new RefDynamicTableData();
                    $model->group_id = $group_id;
                    $model->$name = $value;
                    if(!$model->save()){
                        Yii::error($model->getErrors(), 'ref_dynamic');
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function getIdColumn()
    {
        return 'id';
    }

    public function getNameColumn()
    {
        if (\Yii::$app->language == 'kz-KZ' || \Yii::$app->language == 'kz') {
            return 'name_kz';
        }
        else { //if (\Yii::$app->language == 'ru-RU') {
            return 'name_ru';
        }
    }
}
