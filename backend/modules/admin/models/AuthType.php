<?php

namespace backend\modules\admin\models;

use Yii;

/**
 * This is the model class for table "auth_type".
 *
 * @property integer $id
 * @property integer $type
 * @property string $description
 */
class AuthType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
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
            'type' => 'Type',
            'description' => 'Description',
        ];
    }
}
