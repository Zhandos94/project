<?php

namespace frontend\modules\auctions\models;

use Yii;

/**
 * This is the model class for table "auc_images_temp".
 *
 * @property integer $id
 * @property string $name
 * @property string $save_name
 * @property integer $general_img
 * @property string $hash
 */
class AucImagesTemp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auc_images_temp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['save_name', 'hash'], 'required'],
            [['general_img'], 'integer'],
            [['name', 'save_name', 'hash'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'save_name' => Yii::t('app', 'Save Name'),
            'general_img' => Yii::t('app', 'General Img'),
            'hash' => Yii::t('app', 'Hash'),
        ];
    }
}
