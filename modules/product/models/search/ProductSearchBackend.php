<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\models\search;

use category\models\Category;
use category\models\query\CategoryQuery;
use product\models\ProductCategory;
use product\models\query\ProductQuery;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use product\models\Product;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * ProductSearch represents the model behind the search form about `product\models\Product`.
 */
class ProductSearchBackend extends ProductSearch
{
    public $dynamicValuesAttribute;
    public function rules()
    {
        $rules = parent::rules();
        $rules[]=[['fieldModels', 'dynamicValuesAttribute'], 'safe'];
        return $rules;
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
        $dataProvider = parent::search($params);

        $this->trigger($this::EVENT_INIT_DYNAMIC_FIELDS);
        $this->loadDynamicData();

        $query = $dataProvider->query;
        /* @var ProductQuery $query */

        if($this->category_id)
            $query->categoryQuery($this->category_id, true);

        $query->with('category');

        $query->groupBy(['product.id']);

        if(!$dataProvider->sort->attributeOrders)
            $query->addOrderByGroupBackend();

        $this->eavSearch($dataProvider);

        if($this->dynamicValuesAttribute!==null){
            if($this->dynamicValuesAttribute)
                $query->andWhere("dynamic_value.id IS NOT NULL");
            else
                $query->andWhere("dynamic_value.id IS NULL");
        }
        return $dataProvider;
    }
}
