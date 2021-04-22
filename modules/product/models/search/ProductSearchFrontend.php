<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\models\search;

use category\models\Category;
use extended\helpers\Helper;
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
class ProductSearchFrontend extends ProductSearch
{

    public $q;
    public function rules()
    {
        $rules = parent::rules();
        $rules[]= ['q', 'safe'];
        return $rules;
    }

    public $noveltyAttribute;
    public $popularAttribute;
    public function formName()
    {
        return "";
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
        /* @var ProductQuery $query */
        $dataProvider = parent::search($params);
        //$dataProvider->pagination->pageSize=4;
        $query = $dataProvider->query;
        $query->enabled();

        if($this->q && Helper::cleanForMatchAgainst($this->q))
            $query->whereByQ(Helper::cleanForMatchAgainst($this->q));

        $query->groupProductsFrontend();
        /*
         * $dataProvider->query->select(["p.*",
            "prices"=>new Expression("GROUP_CONCAT( DISTINCT CONCAT(p.id, '|', p.price) ORDER BY p.price ASC SEPARATOR ',')"),
        ]);*/

        $sort = $dataProvider->sort;
        $sort->attributes['price'] = [
            'label' => Yii::t('product-sort', 'price'),
            'asc' => ['price' => SORT_ASC],
            'desc' => ['price'=> SORT_DESC],
        ];
        $sort->attributes['rating'] = [
            'label' => Yii::t('product-sort', 'rating'),
            'asc' => ['rating' => SORT_DESC],//here is a desc instead of acs
            'desc' => ['rating'=> SORT_ASC],
        ];
        $sort->attributes['noveltyAttribute'] = [
            'label' => Yii::t('product-sort', 'novelties'),
            'asc' => ['noveltyAttribute' => SORT_DESC],//here is a desc instead of acs
            'desc' => ['noveltyAttribute'=> SORT_ASC],
        ];
        $sort->attributes['popularAttribute'] = [
            'label' => Yii::t('product-sort', 'popular'),
            'asc' => ['popularAttribute' => SORT_DESC],//here is a desc instead of acs
            'desc' => ['popularAttribute'=> SORT_ASC],
        ];

        //$sort->defaultOrder = ['id'=>SORT_ASC];
        //$sort->defaultOrder = ['rating'=>SORT_DESC, 'popularAttribute'=>SORT_DESC, 'noveltyAttribute'=>SORT_DESC];
        if(!$sort->attributeOrders)
            $query->addOrderBy(['rating'=>SORT_DESC, 'popularAttribute'=>SORT_DESC, 'noveltyAttribute'=>SORT_DESC]);

        $query->select(['product.*']);
        $query->addSelect(new Expression("IF(FIND_IN_SET(".Product::TYPE_NOVELTY.", product.type), 1, 0) AS noveltyAttribute"));
        $query->addSelect(new Expression("IF(FIND_IN_SET(".Product::TYPE_POPULAR.", product.type), 1, 0) AS popularAttribute"));

        return $dataProvider;
    }
}
