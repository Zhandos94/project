<?php
/**
 * User: BADI
 * DateTime: 21.09.2016 14:36
 */

namespace common\models\refs;


use Yii;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name_ru
 * @property string $name_kz
 * @property integer $disabled
 * @property string $name
 */
abstract class References extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru'], 'required'],
            [['disabled'], 'integer'],
            [['name_ru', 'name_kz'], 'string', 'max' => 255]
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
            'name_ru' => Yii::t('app', 'Name on russian'),
            'name_kz' => Yii::t('app', 'Name on kazakh'),
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