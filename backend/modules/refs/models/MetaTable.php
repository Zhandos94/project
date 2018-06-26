<?php

namespace backend\modules\refs\models;

use yii;
use backend\modules\logs\models\LogRefs;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "meta_table".
 *
 * @property integer $id
 * @property string $table_name
 * @property string $model_name
 * @property integer $disabled
 * @property string $created_at
 * @property string $updated_at
 * @property integer $updated_by
 * @property string $description
 */
class MetaTable extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_meta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['disabled', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['table_name', 'model_name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'model_name' => Yii::t('app', 'Model Name'),
            'disabled' => Yii::t('app', 'Disabled'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    public function writeLogs($prim_key, $action){
        $logs = new LogRefs();
        $logs->table_id = $this->id;
        $logs->column_prim_key = $prim_key;
        $logs->action = $action;
        return $logs->save();
    }
}
