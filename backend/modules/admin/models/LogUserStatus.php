<?php

namespace backend\modules\admin\models;

/**
 * This is the model class for table "log_user_status".
 *
 * @property integer $id
 * @property integer $status
 * @property string $description
 */
class LogUserStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_user_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['description'], 'string', 'max' => 85],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'description' => 'Description',
        ];
    }
}
