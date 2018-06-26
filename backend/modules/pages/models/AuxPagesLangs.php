<?php

namespace backend\modules\pages\models;

use common\models\SysLang;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "aux_pages_langs".
 *
 * @property integer $id
 * @property integer $lang_id
 * @property string $body
 * @property string $title
 * @property AuxPagesData $data
 * @property SysLang $lang
 */
class AuxPagesLangs extends ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aux_pages_langs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lang_id', 'body', 'title'], 'required'],
            [['id', 'lang_id'], 'integer'],
            [['body'], 'string', 'max' => 20000],
            [['title'], 'string', 'max' => 60],
            [['lang_id'], 'unique', 'targetAttribute' => ['id', 'lang_id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lang' => Yii::t('app', 'Lang'),
            'body' => Yii::t('app', 'Body'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getData()
    {
        return $this->hasOne(AuxPagesData::className(), ['id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(SysLang::className(), ['id' => 'lang_id']);
    }

    public static function isEmpty($id, $lang)
    {
        /* @var $langModel SysLang */
        $langModel = SysLang::find()->where(['local' => $lang])->one();
        if($langModel === null){
            Yii::warning("not found language {$lang}", 'pages_warnings');
            $langModel = SysLang::find()->where(['default' => 1])->one();
        }
        $langId = $langModel->id;
        /* @var $langPage AuxPagesLangs */
        $langPage = self::find()->where(['id' => $id, 'lang_id' => $langId])->one();

        return $langPage === null || empty(trim($langPage->body));
    }
}
