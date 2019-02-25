<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace file\models\search;

use article\models\Article;
use category\models\Category;
use comment\models\Comment;
use product\models\Product;
use user\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use file\models\File;
use yii\db\Expression;

/**
 * FileSearch represents the model behind the search form about `common\models\File`.
 */
class FileSearch extends File
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type'], 'integer'],
            [['model_name', 'file_name', 'title', 'model_id'], 'safe'],
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
        $query = File::find()->defaultFrom();

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
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'model_name', $this->model_name])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'title', $this->title])
        ;

        $query->leftJoin("product",['product.id'=>new Expression('file.model_id'), 'file.model_name'=>Product::class]);
        $query->leftJoin("comment",['comment.id'=>new Expression('file.model_id'), 'file.model_name'=>Comment::class]);
        $query->leftJoin("user",['user.id'=>new Expression('file.model_id'), 'file.model_name'=>User::class]);
        $query->leftJoin("category",['category.id'=>new Expression('file.model_id'), 'file.model_name'=>Category::class]);
        $query->leftJoin("article",['article.id'=>new Expression('file.model_id'), 'file.model_name'=>Article::class]);
        $query->groupBy("file.id");

        if($this->model_id){
            if(is_numeric($this->model_id))
                $query->andWhere(['file.model_id'=>$this->model_id]);
            else
                $query->andWhere(['OR',
                    ['LIKE', 'product.title',$this->model_id],
                    ['LIKE', 'comment.text',$this->model_id],
                    ['LIKE', 'article.title',$this->model_id],
                    ['LIKE', 'user.name',$this->model_id],
                    ['LIKE', 'category.title',$this->model_id],
                    ]);
        }

        return $dataProvider;
    }
}
