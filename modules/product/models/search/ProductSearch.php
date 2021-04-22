<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\models\search;

use category\models\Category;
use eav\models\DynamicField;
use eav\models\DynamicValue;
use eav\models\query\DynamicValueQuery;
use extended\behaviours\DateSearchBehaviour;
use product\models\ProductCategory;
use product\models\query\ProductQuery;
use Yii;
use yii\base\Model;
use yii\behaviors\AttributeBehavior;
use yii\data\ActiveDataProvider;
use product\models\Product;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * ProductSearch represents the model behind the search form about `product\models\Product`.
 */
class ProductSearch extends Product
{
    public function behaviors()
    {
        return [
            parent::behaviors()['fieldModelsBehavior'],
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
            [['id', 'user_id', 'status'], 'integer'],
            [['title', 'description', 'created_at', 'updated_at'], 'safe'],
            [['price'], 'number'],
            [['type', 'sku','enabled', 'imagesAttribute'], 'safe'],
            ['category_id', 'safe'],
            ['shop_id', 'safe'],
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

    public function formName()
    {
        return "ProductSearch";
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
        Yii::$app->db->createCommand("SET sql_mode = '';")->execute();
        $query = static::find()->defaultFrom();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
                //'pageSize'=>20,
                //'pageSizeLimit'=>[1,100],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // $query->where('0=1');
            return $dataProvider;
        }

        if($this->category_id)
            $query->categoryQuery($this->category_id, true);

        $query->joinWith('mainImage');
        if($this->imagesAttribute!==null)
            $query->andWhere($this->imagesAttribute ? "file.id IS NOT NULL":"file.id IS NULL");

        $query->andFilterWhere([
            'product.id' => $this->id,
            'product.user_id' => $this->user_id,
            'product.created_at' => $this->created_at,
            'product.updated_at' => $this->updated_at,
            'product.status' => $this->status,
            'product.enabled' => $this->enabled,
        ]);

        $query
            ->andFilterWhere(['like', 'product.title', $this->title])
            ->andFilterWhere(['like', 'product.price', $this->price])
            ->andFilterWhere(['like', 'product.sku', $this->sku])
            ->andFilterWhere(['like', 'product.description', $this->description]);


        if($this->type)
            $query->typeQuery($this->type);


        $query->andFilterWhere(['>=', 'product.price', Yii::$app->request->get('priceFrom')]);
        $query->andFilterWhere(['<=', 'product.price', Yii::$app->request->get('priceTo')]);


        $this->getBehavior('dateSearchCreatedAt')->searchFilterDate($dataProvider);
        $this->getBehavior('dateSearchUpdatedAt')->searchFilterDate($dataProvider);

        return $dataProvider;
    }


    public function eavSearch(&$dataProvider, $relationName='values')
    {
        /* @var ProductQuery $query */
        $query=$dataProvider->query;

        $valueModels = array_filter($this->valueModels);
        $query->joinWith([$relationName=>function(DynamicValueQuery $dynamicValueQuery) use ($valueModels, $query) {
            $dynamicValueQuery->defaultFrom();
            $condition=[];
            foreach ($valueModels as $valueModel)
                if ($valueModel->isNotEmpty)
                    $condition[]= DynamicValue::find()->fieldQuery($valueModel)->where;

            if($condition){
                array_unshift($condition, "OR");
                $dynamicValueQuery->andWhere($condition);
            }
        }]);
    }
}
