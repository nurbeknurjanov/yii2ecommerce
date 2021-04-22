<?php

namespace country\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use country\models\City;

/**
 * CitySearch represents the model behind the search form about `country\models\City`.
 */
class CitySearch extends City
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'region_id'], 'safe'],
            [['name'], 'safe'],
            [['country_id'], 'safe'],
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
        $query = City::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['name'=>SORT_ASC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'city.id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'city.name', $this->name]);

        $query->joinWith('region.country');
        $query->andFilterWhere(['like', 'region.name', $this->region_id]);
        $query->andFilterWhere(['like', 'country.name', $this->country_id]);


        return $dataProvider;
    }
}
