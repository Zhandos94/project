<?php

namespace backend\modules\admin\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * LogUserSearch represents the model behind the search form about `backend\modules\admin\models\LogUser`.
 */
class LogUserSearch extends LogUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_status'], 'integer'],
            [['reason', 'id_user'], 'safe'],
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
        $query = LogUser::find();

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

        $query->joinWith('user');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_status' => $this->id_status,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason])
                ->andFilterWhere(['like', 'user.username', $this->id_user])
                ->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
    public static  function getUserId(){
        $query = LogUserStatus::find()->select('status, name')->where(['in', 'id', [1, 2]])->asArray()->all();

        return $query;
    }

}
