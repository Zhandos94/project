<?php

namespace common\models;

use backend\modules\dimensions\models\DimData;
use backend\modules\dimensions\models\LotDimensions;
use frontend\validators\ValidateCheckBox;
use frontend\validators\ValidateDatetime;
use frontend\validators\ValidateNumeric;
use frontend\validators\ValidateReference;
use frontend\validators\ValidateString;
use common\interfaces\HasDimension;
use frontend\services\dimensions\SaveLotAttrs;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "lot_attribute_val".
 *
 * @property integer $id
 * @property integer $lot_id
 * @property integer $auc_id
 * @property integer $lot_type_id
 * @property integer $dim_id
 * @property string $text
 * @property double $numeric
 * @property string $date
 * @property string $created_at
 * @property string $updated_at
 */
class LotAttributeVal extends ActiveRecord
{

    public $lotTypeId;

    const MAX_LIST_COUNT = 20;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_attribute_val';
    }

    public function rules()
    {
        return [
            [['lot_id', 'auc_id', 'lot_type_id', 'dim_id'], 'integer'],
            [['numeric'], 'number'],
            [['text'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lot_id' => Yii::t('app', 'Lot ID'),
            'auc_id' => Yii::t('app', 'Auc ID'),
            'lot_type_id' => Yii::t('app', 'Lot Type ID'),
            'dim_id' => Yii::t('app', 'Dim ID'),
            'text' => Yii::t('app', 'Text'),
            'numeric' => Yii::t('app', 'Numeric'),
            'date' => Yii::t('app', 'Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function validateAttributes()
    {
        $validateResult = [];
        $lotDims = LotDimensions::find()->where(['lot_type_id' => $this->lotTypeId])->all();
        $post = Yii::$app->request->post($this::formName());
        /* @var $lotDim LotDimensions */
        foreach ($lotDims as $lotDim) {
            $dimension = $lotDim->dimension;
            $dataTypeCode = $dimension->dataType->code;
            if ($dimension->is_required && $dataTypeCode != 'checkbox') {
//                Yii::error($dimension->code, 'lot_attr_error');
                if (!isset($post[$dimension->code]) || empty($post[$dimension->code])) {
                    $validateResult[] = [
                        'id' => 'lot-dim-' . $dimension->code,
                        'message' => Yii::t('app', '{attribute} cannot be blank',
                            ['attribute' => Yii::t('app', $dimension->name)])
                    ];
                }
            }
            if (isset($post[$dimension->code]) && !empty($post[$dimension->code])) {
//                Yii::error($dimension->code, 'lot_attr_error');
                $attribute = $post[$dimension->code];
                switch ($dataTypeCode) {
                    case 'checkbox':
                        $validator = new ValidateCheckBox($dimension, $attribute);
                        break;
                    case 'numeric':
                        $validator = new ValidateNumeric($dimension, $attribute);
                        break;
                    case 'datetime':
                        $validator = new ValidateDatetime($dimension, $attribute);
                        break;
                    case 'ref':
//                        Yii::error($attribute, 'lot_attr_error');
                        $validator = new ValidateReference($dimension, $attribute);
                        break;
                    default: // string
                        $validator = new ValidateString($dimension, $attribute);
                }
//                Yii::error(print_r($validator, true), 'lot_attr_error');
                $isValidated = $validator->execute();
                if ($isValidated !== true) {
                    $validateResult[] = $isValidated;
                }
            }
        }
//        Yii::error(print_r($validateResult, true), 'lot_attr_error');
        return $validateResult;
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $validateAttrs = $this->validateAttributes();
//        Yii::error(print_r($validateAttrs, true), 'lot_attr_error');
        if (empty($validateAttrs)) {
            $validate = parent::validate($attributeNames, $clearErrors);
        } else {
//            Yii::error('not empty array of errors', 'lot_attr_error');
            $validate = $validateAttrs;
        }
        return $validate;
    }

    public function saveValues(HasDimension $lot)
    {
        $save = true;
        $post = Yii::$app->request->post($this::formName());
        if ($post !== null) {
            foreach ($post as $code => $value) {
                if (trim($value != '')) {
                    /* @var $dimension DimData */
                    $dimension = DimData::find()->where(['code' => $code])->one();
                    $saveLotAttrs = new SaveLotAttrs($lot, $dimension, $value);
                    if (!$saveLotAttrs->execute()) {
                        $save = false;
                    }
                }
            }
        }
        return $save;
    }

}
