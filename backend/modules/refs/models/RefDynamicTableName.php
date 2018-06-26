<?php

namespace backend\modules\refs\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ref_dynamic_names".
 *
 * @property integer $id
 * @property string $name
 * @property integer $disabled
 */
class RefDynamicTableName extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_dynamic_table_name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            [['disabled'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name of table'),
            'disabled' => Yii::t('app', 'Disabled')
        ];
    }
}
