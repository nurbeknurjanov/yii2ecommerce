<?php

namespace delivery\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use delivery\models\CronEmailMessage;

/**
 * CronEmailMessageSearch represents the model behind the search form about `common\models\CronEmailMessage`.
 */
class CronEmailMessageSearch extends CronEmailMessage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['created_date', 'recipient_email', 'recipient_name', 'sender_email', 'sender_name', 'subject', 'body', 'sent_date'], 'safe'],
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
        $query = CronEmailMessage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(!isset($_GET['sort']))
            $query->orderBy("id DESC");

        $query->andFilterWhere([
            'id' => $this->id,
            'created_date' => $this->created_date,
            'body' => $this->body,
            'status' => $this->status,
            'sent_date' => $this->sent_date,
        ]);

        $query->andFilterWhere(['like', 'recipient_email', $this->recipient_email])
            ->andFilterWhere(['like', 'recipient_name', $this->recipient_name])
            ->andFilterWhere(['like', 'sender_email', $this->sender_email])
            ->andFilterWhere(['like', 'sender_name', $this->sender_name])
            ->andFilterWhere(['like', 'subject', $this->subject]);

        return $dataProvider;
    }
}
