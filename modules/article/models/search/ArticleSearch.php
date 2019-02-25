<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace article\models\search;

use extended\behaviours\DateSearchBehaviour;
use tag\models\Tag;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use article\models\Article;

/**
 * ArticleSearch represents the model behind the search form about `article\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'title', 'text', 'created_at', 'updated_at'], 'integer'],
            [['tagsAttribute'], 'safe'],
        ];
    }
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
        $query = static::find()->defaultFrom();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith(['tags'=>function($leftQuery){
            $leftQuery->from(['tag'=>Tag::tableName()]);
        }]);
        $query->andFilterWhere(['tag.id'=>$this->tagsAttribute]);

        $query->groupBy("article.id");
        $query->andFilterWhere([
            'article.id' => $this->id,
            'article.type' => $this->type,
            'article.title' => $this->title,
            'article.text' => $this->text,
            'article.created_at' => $this->created_at,
            'article.updated_at' => $this->updated_at,
        ]);

        $this->getBehavior('dateSearchCreatedAt')->searchFilterDate($dataProvider);
        $this->getBehavior('dateSearchUpdatedAt')->searchFilterDate($dataProvider);

        return $dataProvider;
    }
}
