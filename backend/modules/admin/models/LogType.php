<?php

namespace backend\modules\admin\models;


/**
 * This is the model class for table "log_type".
 *
 * @property integer $id
 * @property integer $type
 * @property string $description
 */
class LogType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'description' => 'Description',
        ];
    }
}
