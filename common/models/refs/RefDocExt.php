<?php
/**
 * User: BADI
 * DateTime: 09.10.2016 19:35
 */

namespace common\models\refs;


use Yii;
use yii\db\ActiveRecord;


/**
 * @property integer $id
 * @property integer $disabled
 * @property string $name
 */
class RefDocExt extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_doc_ext';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['disabled'], 'integer'],
            [['disabled'], 'default', 'value' => 0],
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
            'disabled' => Yii::t('app', 'Disabled'),
        ];
    }
}