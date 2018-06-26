<?php

namespace frontend\modules\auctions\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "auc_images".
 *
 * @property integer $id
 * @property integer $auc_id
 * @property string $name
 * @property string $save_name
 * @property integer $general
 * @property integer $status
 * @property integer $locked
 * @property integer $created_by
 * @property string $created_at
 * @property string $updated_at
 */
class AucImages extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auc_images';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'updatedByAttribute' => null,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auc_id', 'save_name'], 'required'],
            [['auc_id', 'general', 'status', 'locked', 'created_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['general'], 'default', 'value' => 0],
            [['name', 'save_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'auc_id' => Yii::t('app', 'Auc ID'),
            'name' => Yii::t('app', 'Name'),
            'save_name' => Yii::t('app', 'Save Name'),
            'general' => Yii::t('app', 'General'),
            'status' => Yii::t('app', 'Status'),
            'locked' => Yii::t('app', 'Locked'),
            'created_by' => Yii::t('app', 'Created By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
