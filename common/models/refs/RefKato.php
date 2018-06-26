<?php

namespace common\models\refs;

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
 * @property string $nn
 * @property string $created_at
 * @property string $updated_at
 * @property string $start_date
 * @property string $end_date
 */
class RefKato extends References
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

    public static function name($te){
        /* @var $kato self*/
        if(($kato = self::find()->where(['te' => $te])->one()) !== null){
            return isset($kato->name) ? $kato->name : '';
        }
        return '';
    }
}
