<?php

namespace frontend\modules\auctions\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\auctions\models\AucImages;

/**
 * AucImagesSearch represents the model behind the search form about `frontend\modules\auctions\models\AucImages`.
 */
class AucImagesSearch extends AucImages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'auc_id', 'general', 'status', 'locked', 'created_by'], 'integer'],
            [['name', 'save_name', 'created_at', 'updated_at'], 'safe'],
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
        $query = AucImages::find();

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
            'auc_id' => $this->auc_id,
            'general' => $this->general,
            'status' => $this->status,
            'locked' => $this->locked,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'save_name', $this->save_name]);

        return $dataProvider;
    }
}
