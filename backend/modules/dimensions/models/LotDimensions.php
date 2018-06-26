<?php

namespace backend\modules\dimensions\models;

use common\models\refs\RefLotTypes;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "lot_dimensions".
 *
 * @property integer $dim_id
 * @property integer $lot_type_id
 * @property integer $row_num
 * @property integer $col_count
 * @property integer $order_in_row
 * @property DimData $dimension
 * @property RefLotTypes $lotType
 *
 */
class LotDimensions extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lot_dimensions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dim_id', 'lot_type_id'], 'required'],
            [['dim_id', 'lot_type_id', 'row_num', 'col_count', 'order_in_row'], 'integer'],
            [['dim_id'], 'unique', 'targetAttribute' => ['dim_id', 'lot_type_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dim_id' => Yii::t('dim', 'Dim ID'),
            'lot_type_id' => Yii::t('dim', 'Lot Type ID'),
            'row_num' => Yii::t('dim', 'Number of row'),
            'col_count' => Yii::t('dim', 'Count of columns in row'),
            'order_in_row' => Yii::t('dim', 'Order of dimension in row'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDimension()
    {
        return $this->hasOne(DimData::className(), ['id' => 'dim_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLotType()
    {
        return $this->hasOne(RefLotTypes::className(), ['id' => 'lot_type_id']);
    }
}
