<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace order\models\search;

use extended\behaviours\DateSearchBehaviour;
use user\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use order\models\Order;
use yii\db\Query;

/**
 * OrderSearch represents the model behind the search form about `order\models\Order`.
 */
class OrderSearch extends Order
{

    public function behaviors()
    {
        return [
            'dateSearchUpdatedAt'=>[
                'class' => DateSearchBehaviour::class,
                'dateAttribute'=>'updated_at',
                'time'=>false,
            ],
            'dateSearchCreatedAt'=>[
                'class' => DateSearchBehaviour::class,
                'dateAttribute'=>'created_at',
                'time'=>false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'delivery_id', 'payment_type'], 'integer'],
            [['name', 'email', 'phone', 'city_id',
                'region_id','country_id','address', 'description', 'created_at', 'updated_at'], 'safe'],
            [['amount'], 'number'],
            [['status'], 'integer'],
            [['nameAttribute'], 'safe'],
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
        $query = Order::find()->defaultFrom();
        $query->with('city');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'payment_type' => $this->payment_type,
            'delivery_id' => $this->delivery_id,
            'city_id' => $this->city_id,
            'region_id' => $this->region_id,
            'country_id' => $this->country_id,
        ]);

        $query
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'amount', $this->amount])
            ->andFilterWhere(['like', 'name', $this->nameAttribute])
        ;

        $this->getBehavior('dateSearchCreatedAt')->searchFilterDate($dataProvider);
        $this->getBehavior('dateSearchUpdatedAt')->searchFilterDate($dataProvider);

        return $dataProvider;
    }
}
