<?php

namespace backend\modules\document\models;


/**
 * This is the model class for table "doc_category".
 *
 * @property integer $id
 * @property string $name
 */
class DocCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doc_category';
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
    public static function getCategory() {
        return DocCategory::find()->asArray()->all();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocCatFormat()
    {
        return $this->hasMany(DocCatFormat::className(), ['cat_id' => 'id']);
    }



}


