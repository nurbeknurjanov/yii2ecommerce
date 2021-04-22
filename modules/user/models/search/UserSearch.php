<?php

namespace user\models\search;

use extended\behaviours\DateSearchBehaviour;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use user\models\User;
use yii\validators\DateValidator;

/**
 * UserSearch represents the model behind the search form about `user\models\User`.
 */
class UserSearch extends User
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

    public $shopsAttribute='';
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username','name', 'email', 'subscribe'], 'safe'],
            ['rolesAttribute', 'safe'],
            ['shopsAttribute', 'safe'],
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith('shops');

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->defaultFrom();

        $query->andFilterWhere([
            'user.id' => $this->id,
            'user.status' => $this->status,
            'user.created_at' => $this->created_at,
            'user.updated_at' => $this->updated_at,
            'user.subscribe' => $this->subscribe,
        ]);

        $query->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'user.name', $this->name])
            ->andFilterWhere(['like', 'shop.title', $this->shopsAttribute])
        ;

        if($this->rolesAttribute){
            $query->leftJoin('{{%auth_assignment}} assignment', 'user.id=assignment.user_id')
                ->groupBy('user.id')
                ->andWhere(['assignment.item_name'=>$this->rolesAttribute]);
        }

        $this->getBehavior('dateSearchCreatedAt')->searchFilterDate($dataProvider);
        $this->getBehavior('dateSearchUpdatedAt')->searchFilterDate($dataProvider);


        return $dataProvider;
    }
}
