<?php

namespace coupon\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use coupon\models\Coupon;

/**
 * CouponSearch represents the model behind the search form about `coupon\models\Coupon`.
 */
class CouponSearch extends Coupon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'discount', 'used', 'reusable'], 'integer'],
            [['title', 'code', 'interval_from', 'interval_to'], 'safe'],
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
        $query = Coupon::find();

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
            'id' => $this->id,
            'discount' => $this->discount,
            'interval_from' => $this->interval_from,
            'interval_to' => $this->interval_to,
            'used' => $this->used,
            'reusable' => $this->reusable,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'code', $this->code]);

        if(isset($_GET['interval_fromFrom']))
			$query->andWhere("interval_from>=STR_TO_DATE('{$_GET['interval_fromFrom']}', '%Y-%m-%d %H:%i:%s')");
        if(isset($_GET['interval_fromTo']))
			$query->andWhere("interval_from<=STR_TO_DATE('{$_GET['interval_fromTo']}', '%Y-%m-%d %H:%i:%s')");

        if(isset($_GET['interval_toFrom']))
			$query->andWhere("interval_to>=STR_TO_DATE('{$_GET['interval_toFrom']}', '%Y-%m-%d %H:%i:%s')");
        if(isset($_GET['interval_toTo']))
			$query->andWhere("interval_to<=STR_TO_DATE('{$_GET['interval_toTo']}', '%Y-%m-%d %H:%i:%s')");

        return $dataProvider;
    }
}
