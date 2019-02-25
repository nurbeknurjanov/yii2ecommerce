<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace eav\models\query;

use category\models\Category;
use eav\models\DynamicField;
use yii\helpers\ArrayHelper;
use Yii;


class DynamicFieldQuery extends  \yii\db\ActiveQuery
{

    /**
     * @return $this
     * */

    public function defaultOrder()
    {
        return $this->orderBy("dynamic_field.position");
    }
    public function defaultFrom()
    {
        return $this->from(['dynamic_field'=>DynamicField::tableName()]);
    }

    public function in_search()
    {
        $this->andWhere(['dynamic_field.section' => DynamicField::SECTION_SEARCH]);
        return $this;
    }

    public function enabled($state = 1)
    {
        $this->andWhere(['dynamic_field.enabled' => $state]);
        return $this;
    }


    /**
     * @return $this
     * @param int $withParent - when some item attached to the middle of categories, withtout detailing till the end
     * */
    public function categoryQuery($category_id, $withChildren=false, $withParent=false, $withNull=false)
    {
        //$category_id можеть и быть и array
        $categories = Category::findAll(['id'=>$category_id]);
        $allCategoriesIDs = ArrayHelper::map($categories, 'id', 'id');
        $categoryCondition = ['dynamic_field.category_id' => $allCategoriesIDs];

        if($withChildren){
            foreach ($categories as $category)
                $allCategoriesIDs = $allCategoriesIDs + ArrayHelper::map($category->children()->all(), 'id', 'id');
            $categoryCondition = ['dynamic_field.category_id' => $allCategoriesIDs];
        }

        if($withParent){
            foreach ($categories as $category)
                $allCategoriesIDs = $allCategoriesIDs + ArrayHelper::map($category->parents()->all(), 'id', 'id');
            $categoryCondition = ['dynamic_field.category_id' => $allCategoriesIDs];
        }

        /*if(!$allCategoriesIDs)//if category is not set
            $categoryCondition="1=1";*/

        $this->andWhere($categoryCondition);

        if($withNull)
            $this->orWhere(['dynamic_field.category_id'=>null]);

        return $this;
    }

    public function orKeyQuery()
    {
        foreach (Yii::$app->request->get() as $queryParam=>$value){
            $queryParam = str_replace('[]', '', $queryParam);
            $this->orWhere(['dynamic_field.key'=>$queryParam]);
        }
        return $this;
    }

    /**
     * @inheritdoc
     * @return \eav\models\DynamicField[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \eav\models\DynamicField|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
} 