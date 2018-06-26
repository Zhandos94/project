<?php

namespace backend\modules\refs\models;

use Yii;

/**
 * This is the model class for table "ref_kato".
 *
 * @property integer $te
 * @property string $ab
 * @property string $cd
 * @property string $ef
 * @property string $hij
 * @property string $k
 * @property string $name_kz
 * @property string $name_ru
 * @property string $nn
 * @property string $created_at
 * @property string $updated_at
 * @property string $start_date
 * @property string $end_date
 * @property integer $disabled
 */
class RefKato extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_kato';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ab', 'cd', 'ef', 'hij', 'k', 'name_kz', 'name_ru'], 'required'],
            [['created_at', 'updated_at', 'start_date', 'end_date'], 'safe'],
            [['disabled'], 'integer'],
            [['ab', 'cd', 'ef', 'k'], 'string', 'max' => 2],
            [['hij'], 'string', 'max' => 3],
            [['name_kz', 'name_ru', 'nn'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'te' => Yii::t('app', 'Te'),
            'ab' => Yii::t('app', 'Ab'),
            'cd' => Yii::t('app', 'Cd'),
            'ef' => Yii::t('app', 'Ef'),
            'hij' => Yii::t('app', 'Hij'),
            'k' => Yii::t('app', 'K'),
            'name_kz' => Yii::t('app', 'Name Kz'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'nn' => Yii::t('app', 'Nn'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
            'disabled' => Yii::t('app', 'Disabled'),
        ];
    }
    public function getName()
    {
        if (\Yii::$app->language == 'kz-KZ' || \Yii::$app->language == 'kz') {
            return $this->name_kz;
        }
        else { //if (\Yii::$app->language == 'ru-RU') {
            return $this->name_ru;
        }
    }
}
