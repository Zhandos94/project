<?php

namespace backend\modules\refs\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "ref_relations_table".
 *
 * @property integer $id
 * @property integer $parent_table_id
 * @property integer $child_table_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property MetaTable $parentTable
 * @property MetaTable $childTable
 */
class RefRelationsTable extends ActiveRecord
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
        return 'ref_relations_table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_table_id', 'child_table_id'], 'required'],
            [['parent_table_id', 'child_table_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_table_id' => Yii::t('app', 'Parent Table ID'),
            'child_table_id' => Yii::t('app', 'Child Table ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return ActiveQuery MetaTable
     */
    public function getParentTable()
    {
        return $this->hasOne(MetaTable::className(), ['id' => 'parent_table_id']);
    }

    /**
     * @return ActiveQuery MetaTable
    */
    public function getChildTable()
    {
        return $this->hasOne(MetaTable::className(), ['id' => 'child_table_id']);
    }
}
