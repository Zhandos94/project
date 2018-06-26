<?php

namespace backend\modules\document\models;

/**
 * This is the model class for table "doc_format".
 *
 * @property integer $id
 * @property string $name
 */
class DocFormat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doc_format';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 62],
            [['name'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
    /**
     * The action get all Category from table doc_category
     */
    public static function getFormat() {
        return DocFormat::find()->asArray()->all();
    }
}
