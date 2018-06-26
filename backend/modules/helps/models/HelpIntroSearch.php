<?php

namespace backend\modules\helps\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\helps\models\HelpIntro;

/**
 * HelpIntroSearch represents the model behind the search form about `common\models\HelpIntro`.
 */
class HelpIntroSearch extends HelpIntro
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id', 'is_guest', 'is_main', 'is_only'], 'integer'],
			[['page_id', 'element_id', 'body', 'description', 'position', 'variant_two'], 'safe'],
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
		$query = HelpIntro::find();

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
			'is_guest' => $this->is_guest,
            'is_main' => $this->is_main,
            'is_only' => $this->is_only,
		]);

		$query->andFilterWhere(['like', 'page_id', $this->page_id])
			->andFilterWhere(['like', 'element_id', $this->element_id])
			->andFilterWhere(['like', 'body', $this->body])
			->andFilterWhere(['like', 'description', $this->description])
			->andFilterWhere(['like', 'position', $this->position])
			->andFilterWhere(['like', 'variant_two', $this->variant_two]);

		return $dataProvider;
	}

    public static function is_main()
    {
        $query = Yii::$app->db->createCommand('SELECT DISTINCT is_main FROM hlp_intro ORDER BY is_main DESC')->queryColumn();
        $is_main = [];
        foreach ($query as $q) {
            $option = Yii::t('app', $q ? 'main' : 'no main');
            $is_main[$q] = $option;
        }
        return $is_main;
    }

    public static function is_only()
    {
        $query = Yii::$app->db->createCommand('SELECT DISTINCT is_only FROM hlp_intro ORDER BY is_only DESC')->queryColumn();
        $is_only = [];
        foreach ($query as $q) {
            $option = Yii::t('app', $q ? 'only' : 'no only');
            $is_only[$q] = $option;
        }
        return $is_only;
    }
}
