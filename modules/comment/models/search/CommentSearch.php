<?php

namespace comment\models\search;

use extended\behaviours\DateSearchBehaviour;
use product\models\query\ProductQuery;
use product\models\query\RatingQuery;
use product\models\Rating;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use comment\models\Comment;
use user\models\User;
use yii\db\Expression;

/**
 * CommentSearch represents the model behind the search form about `comment\models\Comment`.
 */
class CommentSearch extends Comment
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['model_name', 'ip', 'name', 'text', 'created_at', 'updated_at', 'user_id'], 'safe'],
            [['model_id'], 'safe'],
            [['nameAttribute'], 'safe'],
            [['ratingOrderAttribute'], 'safe'],
        ];
    }
    public $nameAttribute;

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
        $query = Comment::find();

        $query->defaultFrom();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['rating'=>function(RatingQuery $leftQuery){
            $leftQuery->defaultFrom();
        }]);

        $query->with('likes');




        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith(['user'=>function($leftQuery){
            $leftQuery->from(['user'=>User::tableName()]);
        }]);
        $query->andFilterWhere(['OR', ['LIKE','user.name', $this->nameAttribute], ['LIKE','comment.name', $this->nameAttribute]] );


        $query->joinWith(['product'=>function(ProductQuery $leftQuery){
            $leftQuery->defaultFrom();
        }]);
        $query->andFilterWhere(['OR', ['LIKE','product.title', $this->model_id], ['product.id'=>$this->model_id]] );

        $query->andFilterWhere([
            'comment.id' => $this->id,
            'comment.created_at' => $this->created_at,
            'comment.updated_at' => $this->updated_at,
            'rating.mark' => $this->ratingOrderAttribute,
        ]);

        $query
            ->andFilterWhere(['like', 'comment.model_name', $this->model_name])
            ->andFilterWhere(['like', 'user.name', $this->user_id])
            ->andFilterWhere(['like', 'comment.ip', $this->ip])
            ->andFilterWhere(['like', 'comment.name', $this->name])
            ->andFilterWhere(['like', 'comment.text', $this->text]);

        $this->getBehavior('dateSearchCreatedAt')->searchFilterDate($dataProvider);
        $this->getBehavior('dateSearchUpdatedAt')->searchFilterDate($dataProvider);

        return $dataProvider;
    }
}
