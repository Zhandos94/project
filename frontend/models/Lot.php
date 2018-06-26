<?php

namespace frontend\models;

use common\interfaces\HasDimension;
use common\models\refs\RefKato;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "lot_data".
 *
 * @property integer $id
 * @property integer $auc_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $user_id
 * @property integer $addr_level1_id
 * @property integer $addr_level2_id
 * @property integer $addr_level3_id
 * @property integer $addr_level4_id
 * @property string $other
 * @property string $condition
 * @property string $location
 * @property integer $lot_type_id
 *
 * @property string $fullLocation
 */
class Lot extends ActiveRecord implements HasDimension
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_data';
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            /*            [
                            'class' => TimestampBehavior::className(),
                            'createdAtAttribute' => 'dateCr',
                            'updatedAtAttribute' => 'dateUpd',
                            'value' => new Expression('NOW()'),
                        ],*/
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => null, //'lastupdateuserid',
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['auc_id'], 'required'],
            [['location', 'lot_type_id'], 'required'],
            [['auc_id', 'user_id', 'addr_level1_id', 'addr_level2_id', 'addr_level3_id', 'addr_level4_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['other', 'condition'], 'string', 'max' => 400],
            [['location'], 'string', 'max' => 500],
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
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_id' => Yii::t('app', 'User ID'),
            'addr_level1_id' => Yii::t('app', 'Область/Город'),
            'addr_level2_id' => Yii::t('app', 'Город/Район'),
            'addr_level3_id' => Yii::t('app', 'Районный центр/Поселок/Аул/Район'),
            'addr_level4_id' => Yii::t('app', 'Населенный пункт'),
            'other' => Yii::t('app', 'Прочее'),
            'condition' => Yii::t('app', 'Состояние'),
            'location' => Yii::t('app', 'Lot location'),
            'lot_type_id' => Yii::t('app', 'Type of lot')
        ];
    }

    public function getAddrName($addr_id) {
        /* @var $refKato RefKato */
        if (($refKato = RefKato::find()->where(['te' => $addr_id])->one()) != null) {
            return $refKato->name;
        };

        return 'Не найдено';
    }

    public function getFullLocation() {
        $addr_1 = (is_null($this->addr_level1_id) ? '' : $this->getAddrName($this->addr_level1_id).', ');
        $addr_2 = (is_null($this->addr_level2_id) ? '' : $this->getAddrName($this->addr_level2_id).', ');
        $addr_3 = (is_null($this->addr_level3_id) ? '' : $this->getAddrName($this->addr_level3_id).', ');
        $addr_4 = (is_null($this->addr_level4_id) ? '' : $this->getAddrName($this->addr_level4_id).', ');
        return $addr_1.$addr_2.$addr_3.$addr_4.$this->location;
    }

    public function getLotTypeId()
    {
        return $this->lot_type_id;
    }

    public function getAucId()
    {
        return $this->auc_id;
    }

    public function getLotId()
    {
        return $this->id;
    }
}