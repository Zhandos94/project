<?php

namespace backend\modules\logs\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\logs\models\LogDimData;
use backend\modules\dimensions\models\DimData;


/**
 * LogDimDataSearch represents the model behind the search form about `backend\modules\logs\models\LogDimData`.
 */
class LogDimDataSearch extends LogDimData
{
    public $action;
    public $dimData;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['action', 'date', 'dim_id'], 'safe'],
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
        $query = LogDimData::find();

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

        $query->joinWith('dimData');
        // grid filtering conditions
        $query->andFilterWhere([
//            'id' => $this->id,
            'user_id' => $this->user_id,
//            'dim_id' => $this->dim_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'name', $this->dim_id])
            ->andFilterWhere(['like', 'log_dim_data.id', $this->id])
            ->andFilterWhere(['like', 'name', $this->dimData])
            ->andFilterWhere(['like', 'action', $this->action]);

        return $dataProvider;
    }

    public static function logDimAction()
    {
        $query = Yii::$app->db->createCommand('
          SELECT DISTINCT action FROM log_dim_data 
          ')->queryColumn();
        $readed = [];
        foreach ($query as $q) {
            $readed[$q] = $q;
        }
        return $readed;
    }


}
