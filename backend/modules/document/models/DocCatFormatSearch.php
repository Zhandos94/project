<?php

namespace backend\modules\document\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * docCatFormatSearch represents the model behind the search form about `backend\modules\document\models\docCatFormat`.
 */
class DocCatFormatSearch extends DocCatFormat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['cat_id', 'for_id'], 'string'],
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
        $query = DocCatFormat::find();

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

        $query->joinWith('docCategory');
        $query->joinWith('docFormat');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'doc_category.name', $this->cat_id])
                ->andFilterWhere(['like', 'doc_format.name', $this->for_id]);

        return $dataProvider;
    }
}
