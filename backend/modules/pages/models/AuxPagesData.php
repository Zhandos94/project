<?php

namespace backend\modules\pages\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $code
 * @property integer $is_public
 * @property AuxPagesLangs[] $langs
 * @property string $description
 */
class AuxPagesData extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aux_pages_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['is_public', 'id'], 'integer'],
            [['code'], 'string', 'max' => 40],
            [['code'], 'unique'],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Code'),
            'is_public' => Yii::t('app', 'Is Public'),
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Pages Data Description'),
        ];
    }

    /**
     * @return ActiveQuery
    */
    public function getLangs()
    {
        return $this->hasMany(AuxPagesLangs::className(), ['id' => 'id']);
    }
}
