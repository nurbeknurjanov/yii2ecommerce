<?php

namespace i18n\models\search;

use i18n\models\I18nSourceMessage;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use i18n\models\I18nMessage;
use yii\db\ActiveQuery;

/**
 * I18nMessageSearch represents the model behind the search form about `i18n\models\I18nMessage`.
 */
class I18nMessageSearch extends I18nMessage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['language', 'translation', 'sourceMessage'], 'safe'],
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
        $query = I18nMessage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['source'=>function(ActiveQuery $sourceQuery){
            $sourceQuery->from(['source'=>I18nSourceMessage::tableName()]);
        }]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'source.message', $this->sourceMessage]);


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'translation', $this->translation]);

        return $dataProvider;
    }
}
