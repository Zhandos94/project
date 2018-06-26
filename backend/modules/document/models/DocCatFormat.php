<?php

namespace backend\modules\document\models;


/**
 * This is the model class for table "doc_cat_format".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property integer $for_id
 */
class DocCatFormat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doc_cat_format';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'for_id'], 'integer'],
            [['cat_id', 'for_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'for_id' => 'For ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocCategory()
    {
        return $this->hasOne(DocCategory::className(), ['id' => 'cat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocFormat()
    {
        return $this->hasOne(DocFormat::className(), ['id' => 'for_id']);
    }


}
