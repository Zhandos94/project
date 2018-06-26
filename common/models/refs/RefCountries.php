<?php

namespace common\models\refs;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ref_countries".
 *
 * @property integer $code
 * @property string $created_at
 * @property string $updated_at
 * @property string $start_date
 * @property string $end_date
 */
class RefCountries extends References
{
    const COUNTRY_KZ = 398;
    const COUNTRY_RU = 643;
    const COUNTRY_BELARUS = 112;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name_kz'], 'required'],
            [['name_ru', 'name_kz'], 'string', 'max' => 100],
            [['created_at', 'updated_at', 'start_date', 'end_date'], 'safe'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'code' => Yii::t('app', 'Code'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
        ]);
    }
}
