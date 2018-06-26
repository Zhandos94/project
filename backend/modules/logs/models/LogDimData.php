<?php

namespace backend\modules\logs\models;

use backend\modules\dimensions\models\DimData;
use Yii;

/**
 * This is the model class for table "log_dim_data".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $action
 * @property integer $dim_id
 * @property string $date
 */
class LogDimData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_dim_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'dim_id'], 'integer'],
            [['date'], 'safe'],
            [['action'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'action' => 'Action',
            'dim_id' => 'Dim ID',
            'date' => 'Date',
        ];
    }

    /**
     Insert DB table log_dim_data
     */

    public function logWrite($action, $dim_id) {

        $this->user_id = Yii::$app->user->getId();
        $this->action = $action;
        $this->dim_id = $dim_id;
        $this->date = date("Y-m-d H:i:s");

        return $this->save();
    }

    public function getDimData()
    {
        return $this->hasOne(DimData::className(), ['id' => 'dim_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
