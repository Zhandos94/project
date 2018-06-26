<?php

namespace backend\modules\dimensions\models;

use backend\modules\dimensions\validators\RelConditionValidator;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dim_relations".
 *
 * @property integer $parent_dim_id
 * @property integer $child_dim_id
 * @property string $condition
 * @property integer $disabled
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property integer $extra_toggle
 */
class DimRelations extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dim_relations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_dim_id', 'child_dim_id'], 'required'],
            [['parent_dim_id', 'child_dim_id', 'disabled', 'created_by', 'updated_by', 'extra_toggle'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['parent_dim_id', 'child_dim_id'], 'unique', 'targetAttribute' => ['parent_dim_id', 'child_dim_id']],
            [['condition'], 'string', 'max' => 255],
            [['condition'], RelConditionValidator::className()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent_dim_id' => Yii::t('dim', 'Parent Dim ID'),
            'child_dim_id' => Yii::t('dim', 'Child Dim ID'),
            'condition' => Yii::t('dim', 'Condition'),
            'disabled' => Yii::t('dim', 'Disabled'),
            'created_at' => Yii::t('dim', 'Created At'),
            'updated_at' => Yii::t('dim', 'Updated At'),
            'created_by' => Yii::t('dim', 'Created By'),
            'updated_by' => Yii::t('dim', 'Updated By'),
            'extra_toggle' => Yii::t('dim', 'Extra toggle'),
        ];
    }
}
