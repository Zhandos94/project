<?php

namespace backend\modules\refs\models;

use yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ref_receivers_sources".
 *
 * @property integer $id
 * @property string $name
 */
class RefReceiversSources extends References
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_receivers_sources';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name'], 'string', 'max' => 255],
            [['id'], 'integer'],
            [['disabled'], 'default', 'value' => 0],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ]);
    }
    
    public static function sources(){
        $sources = RefReceiversSources::find()->where(['or',['disabled' => 0],['disabled' => null]])->all();
        return ArrayHelper::map($sources, 'id', 'name');
    }
}
