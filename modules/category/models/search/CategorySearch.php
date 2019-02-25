<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace category\models\search;

use category\models\CategoryBehavior;
use file\models\File;
use file\models\query\FileQuery;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use category\models\Category;

/**
 * CategorySearch represents the model behind the search form about `category\models\Category`.
 */
class CategorySearch extends Category
{
    public function behaviors()
    {
        return [
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tree', 'lft', 'rgt', 'depth'], 'integer'],
            [['title', 'title_url', 'data', 'text'], 'safe'],
            [['imageAttribute', 'enabled'], 'safe'],
            [['title_ru'], 'safe'],
            //[['title_seo'], 'safe'],
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
        $query = Category::find()->defaultFrom();

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
            'category.id' => $this->id,
            'category.tree' => $this->tree,
            'category.lft' => $this->lft,
            'category.rgt' => $this->rgt,
            'category.depth' => $this->depth,
            'category.enabled' => $this->enabled,
        ]);

        $query->andFilterWhere(['like', 'category.title', $this->title]);


        $query->joinWith(['image'=>function(FileQuery $fileQuery){
            $fileQuery->defaultFrom();
        }]);
        $query->groupBy('category.id');
        if($this->imageAttribute!==null)
            $query->andWhere($this->imageAttribute ? "file.id IS NOT NULL":"file.id IS NULL");

        $query->andFilterWhere(['like', 'category.title', $this->title]);
        $query->andFilterWhere(['like', 'category.title_url', $this->title_url]);
        $query->andFilterWhere(['like', 'category.text', $this->text]);

        //$query->andFilterWhere(['like', 'category.title_ru', $this->title_ru]);
        //$query->andFilterWhere(['like', 'data', $this->title_seo]);


        $query->defaultOrder();
        $query->selectTitle();

        return $dataProvider;
    }
}
