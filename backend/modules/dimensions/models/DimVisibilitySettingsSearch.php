<?php

namespace backend\modules\dimensions\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DimVisibilitySettingsSearch represents the model behind the search form about `backend\modules\dimensions\models\DimVisibilitySettings`.
 */
class DimVisibilitySettingsSearch extends DimVisibilitySettings
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_dim_id', 'child_dim_id', 'disabled', 'created_by', 'updated_by'], 'integer'],
            [['condition', 'created_at', 'updated_at'], 'safe'],
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
        $query = DimVisibilitySettings::find();

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
            'parent_dim_id' => $this->parent_dim_id,
            'child_dim_id' => $this->child_dim_id,
            'disabled' => $this->disabled,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'condition', $this->condition]);

        return $dataProvider;
    }
}
