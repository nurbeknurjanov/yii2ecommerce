<?php

namespace like\models\search;

use comment\models\Comment;
use extended\behaviours\DateSearchBehaviour;
use extended\helpers\Helper;
use Yii;
use yii\base\Model;
use yii\behaviors\AttributeBehavior;
use yii\data\ActiveDataProvider;
use like\models\Like;

/**
 * LikeSearch represents the model behind the search form about `like\models\Like`.
 */
class LikeSearch extends Like
{
    public function behaviors()
    {
        return [
            'dateSearchCreatedAt'=>[
                'class' => DateSearchBehaviour::class,
                'dateAttribute'=>'created_at',
            ],
            'dateSearchUpdatedAt'=>[
                'class' => DateSearchBehaviour::class,
                'dateAttribute'=>'updated_at',
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_INIT => 'model_name',
                ],
                'value' => function ($event) {
                    return Comment::class;
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'user_id', 'mark'], 'integer'],
            [['model_name', 'ip'], 'safe'],
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
        $query = Like::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere([
            'like.id' => $this->id,
            'like.user_id' => $this->user_id,
            'like.mark' => $this->mark,
        ]);

        $query->andFilterWhere(['like', 'like.model_name', $this->model_name])
            ->andFilterWhere(['like', 'like.ip', $this->ip]);

        if($this->model_name){
            $objectID = Helper::getId($this->model_name);
            $query->joinWith($objectID);
            $query->andFilterWhere(['OR', ['LIKE',"$objectID.text", $this->model_id], ["$objectID.id"=>$this->model_id]] );
        }



        $this->getBehavior('dateSearchCreatedAt')->searchFilterDate($dataProvider);
        $this->getBehavior('dateSearchUpdatedAt')->searchFilterDate($dataProvider);

        return $dataProvider;
    }
}
