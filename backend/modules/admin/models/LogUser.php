<?php

namespace backend\modules\admin\models;

use Yii;


/**
 * This is the model class for table "log_user".
 *
 * @property integer $id
 * @property string $reason
 * @property integer $id_user
 * @property integer $id_status
 * @property string $date
 */
class LogUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reason',], 'required', 'message' => Yii::t('app', 'The field Reason must not be empty')],
            [['id_user', 'id_status'], 'integer'],
            [['date'], 'safe'],
            [['reason'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reason' => 'Reason',
            'id_user' => 'Id User',
            'id_status' => 'Id Status',
            'date' => 'Date',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    public function getLogUserStatus()
    {
        return $this->hasOne(LogUserStatus::className(), ['id' => 'id_status']);
    }


    /**
     * The function writeLogUser writes data in table log_user
     * @param integer $id_user [The table user's ID]
     * @param integer $status [The table status's ID]
     * @param string $reason
     * @return true or false
     */
    public function  writeLogUser($id_user, $status, $reason)
    {
        if($this->validate()){
            $this->reason = $reason;
            $this->id_user = $id_user;
            $this->id_status = $status;
            $this->date = date("Y-m-d H:i:s");

            if ($this->save()){
                return true;
            }
        }
        return false;
    }
}
