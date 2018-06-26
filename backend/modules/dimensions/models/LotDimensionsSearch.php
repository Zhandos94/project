<?php
/**
 * Created by BADI.
 * DateTime: 20.12.2016 12:18
 */

namespace backend\modules\dimensions\models;


use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class LotDimensionsSearch extends LotDimensions
{

    public $dim_name;
    public $dim_data_type;

    public function rules()
    {
        return [
            [['lot_type_id', 'dim_id'], 'integer'],
            [['dim_name', 'dim_data_type'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(),[
            'dim_name' => 'Dimension Name',
            'dim_data_type' => 'Dimension Data Type'
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LotDimensions::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort(['attributes' => ['dim_name', 'dim_data_type']]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'lot_type_id' => $this->lot_type_id,
            'dim_id' => $this->dim_id,
        ]);

        return $dataProvider;
    }
}