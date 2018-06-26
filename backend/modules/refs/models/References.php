<?php
/**
 * User: TOLK   created by IntelliJ IDEA.
 * Date: 13.08.2015 10:35
 */

namespace backend\modules\refs\models;


use yii;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name_ru
 * @property string $name_kz
 * @property integer $disabled
 *
 * @property string $name
 */
class References extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_ru'], 'required'],
            [['disabled'/*, 'id'*/], 'integer'], //TODO if we will need for save ID from POST
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
            'name' => Yii::t('app', 'Наименование'),
            'name_ru' => Yii::t('app', 'Наименование на русском'),
            'name_kz' => Yii::t('app', 'Наименование на казахском'),
            'disabled' => Yii::t('app', 'Disabled'),
            'code' => Yii::t('app', 'Code'),
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