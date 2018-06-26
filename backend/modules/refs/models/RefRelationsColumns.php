<?php

namespace backend\modules\refs\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "ref_relations_columns".
 *
 * @property integer $id
 * @property integer $relation_id
 * @property string $parent_column
 * @property string $child_column
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class RefRelationsColumns extends ActiveRecord
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
        return 'ref_relations_columns';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['relation_id', 'parent_column', 'child_column'], 'required'],
            [['relation_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['parent_column', 'child_column'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'relation_id' => Yii::t('app', 'Relation ID'),
            'parent_column' => Yii::t('app', 'Parent Column'),
            'child_column' => Yii::t('app', 'Child Column'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
}
