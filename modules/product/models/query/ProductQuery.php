<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\models\query;

use favorite\models\Favorite;
use favorite\models\FavoriteLocal;
use i18n\models\I18nMessage;
use i18n\models\I18nSourceMessage;
use order\models\Basket;
use product\models\Product;
use product\models\Viewed;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use category\models\Category;
use Yii;
use product\models\Compare;

/**
 * This is the ActiveQuery class for [[\product\models\Product]].
 *
 * @see \product\models\Product
 */
class ProductQuery extends \yii\db\ActiveQuery
{
    public function randomly()
    {
        return $this->orderBy("RAND()");
    }
    public function not(Product $model)
    {
        return $this->andWhere(['!=', 'product.id', $model->id]);
    }
    public function notTheSame(Product $model)
    {
        $this->not($model);
        if($model->group_id)
            $this->andWhere(['OR',
                ['!=', 'product.group_id', $model->group_id],
                ['product.group_id'=>null]
            ]);
        return $this;
    }
    public function discountQuery()
    {
        $this->andWhere('product.discount IS NOT NULL AND product.discount>0');
        $this->orderBy('product.discount DESC');
        return $this;
    }

    public function categoryQuery($category_id, $withChildren=false)
    {
        //$category_id можеть и быть и array
        $categories = Category::findAll(['id'=>$category_id]);
        $allCategoriesIDs = ArrayHelper::map($categories, 'id', 'id');
        $condition = ['product.category_id' => $allCategoriesIDs];

        if($withChildren){
            foreach ($categories as $category)
                $allCategoriesIDs = $allCategoriesIDs + ArrayHelper::map($category->children()->all(), 'id', 'id');
            $condition = ['product.category_id' => $allCategoriesIDs];
        }

        return $this->andWhere($condition);
    }


    public function typeQuery($type)
    {
        return $this->andWhere("FIND_IN_SET($type, product.type)");
    }
    public function novelty()
    {
        return $this->andWhere("FIND_IN_SET(".Product::TYPE_NOVELTY.", product.type)");
    }
    public function popular()
    {
        return $this->andWhere("FIND_IN_SET(".Product::TYPE_POPULAR.", product.type)");
    }
    public function promote()
    {
        return $this->andWhere("FIND_IN_SET(".Product::TYPE_PROMOTE.", product.type)");
    }
    public function groupProductsFrontend()
    {
        Yii::$app->db->createCommand("SET sql_mode = '';")->execute();
        //return $this->groupBy([new Expression('IF(product.group_id IS NULL, product.id, product.group_id)')]);will not work
        return $this->groupBy([new Expression('IF(product.group_id IS NULL, product.id, 0)')]);
    }
    public function addOrderByGroupBackend()
    {
        return $this->addOrderBy(new Expression('IF(product.group_id IS NOT NULL,
             product.group_id, product.id) ASC'));
    }

    public function whereByQ($q, $lengthTerm=3)
    {
        if($q){
            $qCondition = ['OR', ['product.id'=>$q], ['product.sku'=>$q]];
            if(!$lengthTerm || strlen($q)>=$lengthTerm)
            {

                $qCondition = ['OR', $qCondition,"MATCH (product.title, product.description) AGAINST (:q  IN BOOLEAN MODE)"];
                $this->addParams([':q'=>$q]);
                $this->addOrderBy("MATCH (product.title, product.description) AGAINST (:q  IN BOOLEAN MODE) DESC");

                $qCondition = ['OR', $qCondition,"MATCH (dynamic_value.value) AGAINST (:q  IN BOOLEAN MODE)"];
                $this->addOrderBy("MATCH (dynamic_value.value) AGAINST (:q  IN BOOLEAN MODE) DESC");

                /*$qWords = explode(' ', $q);
                $qWords = array_filter($qWords, function($var) use ($lengthTerm){
                    return !$lengthTerm || strlen($var)>=$lengthTerm;
                });
                foreach ($qWords as $q){
                    $qCondition = ['OR', $qCondition,['OR',['like','product.title',$q],['like','product.description',$q]]];
                    $qCondition = ['OR', $qCondition,['like','dynamic_value.value',$q]];
                }*/

                $categoryIDs = Category::find()->defaultFrom()->whereByQTranslate($q)->select('id')->createCommand()->queryAll();
                $categoryIDs = ArrayHelper::map($categoryIDs, 'id', 'id');
                if($categoryIDs)
                    foreach ($categoryIDs as $categoryID) {
                        $newQuery = new self(Product::class);
                        $newQuery->categoryQuery($categoryID, true);
                        $qCondition = ['OR', $qCondition,$newQuery->where];
                    }
            }
            $this->andWhere($qCondition);
        }
        return $this;
    }




    public function defaultFrom()
    {
        return $this->from(['product'=>Product::tableName()]);
    }

    public function enabled($state=1)
    {
        return $this->andWhere(['product.enabled'=>$state]);
    }



    public function similar(Product $model)
    {
        Yii::$app->db->createCommand("SET sql_mode = '';")->execute();

        $this->categoryQuery($model->category_id, true);
        $this->notTheSame($model);

        $conditions=[];
        foreach ($model->values as $value) {
            $values = $value->value;
            $values = explode(',', $values);
            array_walk($values, function(&$value){
                $value = "FIND_IN_SET('$value', dynamic_value.value)";
            });
            $values = implode(' OR ', $values);
            $conditions[]="dynamic_value.field_id='{$value->field_id}' AND ($values)";
        }
        $conditions=implode(' OR ', $conditions);

        $this->joinWith(['values'=>function($leftQuery) use ($conditions){
            $leftQuery->defaultFrom();
            $leftQuery->andOnCondition($conditions);
        }]);
        $this->groupBy("product.id");

        $this->orderBy(new Expression("COUNT(dynamic_value.id) DESC"));
        return $this;
    }


    public function viewed()
    {
        $viewedProducts = Viewed::findAll();

        usort($viewedProducts, function($a, $current){
            if($a['date'] == $current['date']){
                return $a['date'] > $current['date'];
            }
            if($a['date'] < $current['date'])
                return true;
            if($a['date'] > $current['date'])
                return false;
        });

        $viewedProducts = ArrayHelper::map($viewedProducts, 'id', 'date');

        $ids = array_keys($viewedProducts);
        $this->andWhere(['product.id'=>$ids]);

        if($ids){
            $ids = implode(',', $ids);
            $this->orderBy(new Expression("FIELD(product.id,$ids)"));
        }
        return $this;
    }
    public function favorite()
    {
        $favorites = FavoriteLocal::findAll();

        usort($favorites, function($b, $a) {
            return strtotime($a['created_at']) - strtotime($b['created_at']);
        });

        $favorites = ArrayHelper::map($favorites, 'model_id', 'created_at');

        $ids = implode(',', array_keys($favorites));

        $this->andWhere(['product.id'=>array_keys($favorites)]);
        if($ids)
            $this->orderBy(new Expression("FIELD(product.id,$ids)"));
        //$this->select(['product.*', 'fieldAttribute'=>'product.id']);
        return $this;
    }
    public function compare()
    {
        return $this->andWhere(['id'=>Compare::findAll()]);
    }
    public function inBasket()
    {
        $products = Basket::findAll();
        $products = ArrayHelper::map($products, 'product_id', 'count');
        $IDs = array_keys($products);
        if($IDs){
            $this->andWhere(['product.id'=>$IDs]);
            $this->orderBy(new Expression("FIELD(product.id, ".implode(',', $IDs).")"));
        }else{
            $this->andWhere("1=0");
        }
        return $this;
    }


    /**
     * @inheritdoc
     * @return \product\models\Product[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \product\models\Product|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}