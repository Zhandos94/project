<?php

namespace backend\modules\dimensions\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DimDataSearch represents the model behind the search form about `backend\modules\dimensions\models\DimData`.
 */
class DimDataSearch extends DimData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_active', 'type_id', 'is_required', 'negative_allow', 'decimal_sym_num', 'max_length',
                'ref_id', 'group_id', 'created_by', 'updated_by', 'min_length'], 'integer'],
            [['code', 'name', 'min_date', 'max_date', 'relation_min', 'relation_max', 'created_at', 'updated_at'], 'safe'],
            [['min_val', 'max_val'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = DimData::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_active' => $this->is_active,
            'type_id' => $this->type_id,
            'is_required' => $this->is_required,
            'min_date' => $this->min_date,
            'max_date' => $this->max_date,
            'min_val' => $this->min_val,
            'max_val' => $this->max_val,
            'negative_allow' => $this->negative_allow,
            'decimal_sym_num' => $this->decimal_sym_num,
            'max_length' => $this->max_length,
            'min_length' => $this->min_length,
            'ref_id' => $this->ref_id,
            'group_id' => $this->group_id,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'relation_min', $this->relation_min])
            ->andFilterWhere(['like', 'relation_max', $this->relation_max])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
