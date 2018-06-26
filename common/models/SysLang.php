<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sys_lang".
 *
 * @property integer $id
 * @property string $url
 * @property string $local
 * @property string $name
 * @property integer $default
 * @property integer $date_update
 * @property integer $date_create
 */
class SysLang extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_lang';
    }

    public static function langs()
    {
        $langs = self::find()->all();
        return ArrayHelper::map($langs, 'id', 'name');
    }

    public static function langByLocal($default = false){
        $cookies = Yii::$app->request->cookies;
        $language = $cookies->getValue('language');
        if(($langModel = self::find()->where(['local' => $language])->one()) === null || $default){
            $langModel = self::findOne(['default' => 1]);
        }
        return $langModel->id;
    }
}
