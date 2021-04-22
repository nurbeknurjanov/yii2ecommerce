<?php

namespace shop\models\search;

use extended\helpers\ArrayHelper;
use user\models\query\UserQuery;
use user\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use shop\models\Shop;

/**
 * ShopSearch represents the model behind the search form about `shop\models\Shop`.
 */
class ShopSearch extends Shop
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'title_url', 'description', 'address', 'ownerAttribute', 'usersAttribute'], 'safe'],
        ];
    }

    public $usersAttribute='';

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
        $query = Shop::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);



        $this->load($params);


        $model = $this;
        $query->joinWith(['owner'=>function(UserQuery $userQuery) use ($model) {
            //$userQuery->defaultFrom();
            $userQuery->from(['owner'=>User::tableName()]);
            if($model->ownerAttribute)
                $userQuery->whereFilterName($model->ownerAttribute);
        }]);
        $query->joinWith(['users'=>function(UserQuery $userQuery) use ($model) {
            $userQuery->defaultFrom();
            if($model->usersAttribute)
                $userQuery->whereFilterName($model->usersAttribute);
        }]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        if(!Yii::$app->user->can(User::ROLE_ADMINISTRATOR))
            $query->andWhere(['shop.id' => ArrayHelper::map(Yii::$app->user->identity->shops,'id','id')]);


        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title_url', $this->title_url])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address]);



        return $dataProvider;
    }
}
