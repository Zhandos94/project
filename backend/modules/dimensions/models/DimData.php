<?php

namespace backend\modules\dimensions\models;

use backend\modules\dimensions\services\SaveLotDimension;
use backend\modules\dimensions\validators\LotTypeValidator;
use backend\modules\refs\models\MetaTable;
use common\models\refs\RefDimDataTypes;
use common\models\refs\RefLotTypes;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "dim_data".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $visible_label
 * @property integer $is_active
 * @property integer $type_id
 * @property integer $is_required
 * @property string $min_date
 * @property string $max_date
 * @property integer $with_time
 * @property string $min_val
 * @property string $relation_min
 * @property string $max_val
 * @property string $relation_max
 * @property integer $negative_allow
 * @property integer $decimal_sym_num
 * @property integer $max_length
 * @property integer $min_length
 * @property integer $ref_id
 * @property integer $ref_group_id
 * @property string $sort_by
 * @property string $placeholder
 * @property integer $group_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property RefDimDataTypes $dataType
 *
 */
class DimData extends ActiveRecord
{
    public $lotType;
    public $codeId;

    const TYPE_CHECKBOX = 1;
    const TYPE_STRING = 2;
    const TYPE_NUMERIC = 3;
    const TYPE_DATETIME = 4;
    const TYPE_REF = 5;

    const DYNAMIC_REF = -1;

    const SCENARIO_DELETE = 'delete';


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
        return 'dim_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codeId', 'lotType'], 'required', 'when' => function ($model) {
                /* @var $model DimData */
                return $model->isNewRecord;
            }, 'whenClient' => "function(){return 1<0;}"],

            [['name', 'type_id', 'code'], 'required', 'when' => function ($model) {
                /* @var $model DimData */
                return $model->codeId == 9999;
            }, 'whenClient' => "function (attribute, value) {
                    return $('#dimdata-codeid').val() == 9999;
                }"],

            [['is_active', 'type_id', 'is_required', 'negative_allow',
                'decimal_sym_num', 'ref_id', 'group_id', 'lotType', 'with_time',
                'visible_label', 'ref_group_id'], 'integer'],

            [['min_date', 'max_date'], 'safe'],
            [['min_val', 'max_val'], 'number'],
            [['code', 'sort_by'], 'string', 'max' => 255],
            [['name', 'description'], 'string', 'max' => 500],
            [['name'], 'trim'],
            [['max_length'], 'integer', 'min' => 3, 'max' => 5000],
            [['min_length'], 'integer', 'min' => 2],
            [['lotType'], LotTypeValidator::className()],

            [['ref_id'], 'required', 'when' => function ($model) {
                /* @var $model DimData */
                return $model->type_id == self::TYPE_REF;
            }, 'whenClient' => "function(attribute, value) {
                return $('#dimdata-type_id').val() == " . self::TYPE_REF . " && $('#dimdata-codeid').val() == 9999;
            }"],

            [['ref_id'], 'exist', 'targetClass' => MetaTable::className(), 'targetAttribute' => ['ref_id' => 'id']],
            [['placeholder'], 'string', 'max' => 255],
            [['max_length'], 'validateMaxSymCount'],

            [['min_length'], 'required', 'when' => function ($model) {
                /* @var $model DimData */
                return $model->type_id == self::TYPE_STRING;
            }, 'whenClient' => "function(attribute, value){
                    return $('#dimdata-type_id').val() == 2;
                }"],

            [['codeId', 'lotType'], 'unique', 'targetClass' => LotDimensions::className(),
                'targetAttribute' => ['lotType' => 'lot_type_id', 'codeId' => 'dim_id'],
            ],

            [['code'], 'match', 'pattern' => '/^\S{1,}$/i',
                'message' => Yii::t('dim', 'code must not include spaces')],

            [['ref_group_id'], 'required', 'when' => function ($model) {
                /* @var $model DimData */
                return $model->ref_id == self::DYNAMIC_REF;
            }, 'whenClient' => "function(attribute, value){
                    return $('#dimdata-ref_id').val() == " . self::DYNAMIC_REF . ";
                }"],

            [['code'], 'unique'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DELETE] = ['is_active'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('dim', 'ID'),
            'code' => Yii::t('dim', 'Code'),
            'name' => Yii::t('dim', 'Name'),
            'visible_label' => Yii::t('dim', 'Show Label'),
            'is_active' => Yii::t('dim', 'Is Active'),
            'type_id' => Yii::t('dim', 'Type ID'),
            'is_required' => Yii::t('dim', 'Is Required'),
            'min_date' => Yii::t('dim', 'Min Date'),
            'max_date' => Yii::t('dim', 'Max Date'),
            'min_val' => Yii::t('dim', 'Min Val'),
            'relation_min' => Yii::t('dim', 'Relation Min'),
            'max_val' => Yii::t('dim', 'Max Val'),
            'relation_max' => Yii::t('dim', 'Relation Max'),
            'negative_allow' => Yii::t('dim', 'Negative Allow'),
            'decimal_sym_num' => Yii::t('dim', 'Decimal Sym Num'),
            'max_length' => Yii::t('dim', 'Max Length of symbols'),
            'min_length' => Yii::t('dim', 'Min Length of symbols'),
            'ref_id' => Yii::t('dim', 'Ref ID'),
            'ref_group_id' => Yii::t('dim', 'Ref Group ID'),
            'group_id' => Yii::t('dim', 'Group ID'),
            'created_at' => Yii::t('dim', 'Created At'),
            'updated_at' => Yii::t('dim', 'Updated At'),
            'created_by' => Yii::t('dim', 'Created By'),
            'updated_by' => Yii::t('dim', 'Updated By'),
            'with_time' => Yii::t('dim', 'With Time'),
            'placeholder' => Yii::t('dim', 'Placeholder'),
            'description' => Yii::t('dim', 'Description'),
            'codeId' => Yii::t('dim', 'Code ID'),
            'lotType' => Yii::t('dim', 'Type of lot'),
            'lotTypesCount' => Yii::t('dim', 'Count of Lot types'),
            'sort_by' => Yii::t('dim', 'Column to sort reference')
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDataType()
    {
        return $this->hasOne(RefDimDataTypes::className(), ['id' => 'type_id']);
    }

    /**
     * @param $create boolean if it's false, new LotDimensions model will not be created
     * @return boolean
     */
    public function saveDimension($create = true)
    {
        $id = $this->codeId;
        $save = true;
        if (trim($this->code) != '') {
            $save = $this->save();
            $id = $this->id;
        }
        $model = self::findOne($id);
        $saveLotDim = true;
        if ($create) {
            $crLotDim = new SaveLotDimension($model, $this->lotType);
            $saveLotDim = $crLotDim->execute();
        }
        return $saveLotDim && $save;
    }

    public function validateMaxSymCount($attribute)
    {
        if ($this->$attribute <= $this->min_length) {
            $this->addError($attribute, Yii::t('dim', '{attribute} must be greater than {min_length}', [
                'attribute' => $this->getAttributeLabel($this->$attribute),
                'min_length' => $this->getAttributeLabel($this->min_length),
            ]));
        }
    }

    public function getLotTypesCount()
    {
        return LotDimensions::find()->where(['dim_id' => $this->id])->count();
    }

    public function getLotTypeNames()
    {
        $id = LotDimensions::find()->where(['dim_id' => $this->id])->select('lot_type_id')->column();
        $lotTypes = RefLotTypes::findAll($id);
        $lotTypesStrings = null;
        foreach ($lotTypes as $item) {
            $lotTypesStrings .= $item->name . "<br>";
        }

        return $lotTypesStrings;
    }
}
