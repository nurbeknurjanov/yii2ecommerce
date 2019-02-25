<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace category\models\query;

use category\models\Category;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use i18n\models\I18nMessage;
use \yii\db\Expression;
use yii\helpers\ArrayHelper;
use i18n\models\I18nSourceMessage;


/**
 * This is the ActiveQuery class for [[\category\models\Category]].
 *
 * @see \category\models\Category
 */
class CategoryQuery extends \yii\db\ActiveQuery
{
    public function whereByQTranslate($q)
    {
        $messages = I18nMessage::find()->defaultFrom()->whereByQ($q)->select('id')->createCommand()->queryAll();
        $messages = ArrayHelper::map($messages, 'id', 'id');
        $messages = I18nSourceMessage::find()->where(['id'=>$messages])->createCommand()->queryAll();
        $messages = ArrayHelper::map($messages, 'message', 'message');
        array_walk($messages, function(&$var){
            $var = strtolower($var).'*';
        });
        $messages = implode(' ', $messages);
        return $this->whereByQ($q.' '.$messages);
    }
    public function whereByQ($q)
    {
        $this->addOrderBy("MATCH (category.title) AGAINST (:q  IN BOOLEAN MODE) DESC");
        $this->andWhere("MATCH (category.title) AGAINST (:q  IN BOOLEAN MODE)")->addParams([':q'=>$q]);
        //$this->andWhere(['OR', ['category.title'=>$q], ['category.text'=>$q]]);
        return $this;
    }
    public function defaultFrom()
    {
        return $this->from(['category'=>Category::tableName()]);
    }
    public function defaultOrder()
    {
        return $this->orderBy("category.tree_position, category.tree, category.lft");
    }
    public function enabled($state=1)
    {
        return $this->andWhere(['category.enabled'=>$state]);
    }
    public function selectTitle()
    {
        $this->addSelect(['category.*']);
        $this->addSelect(new Expression('CONCAT( REPEAT(\'&nbsp;\', category.depth*5), category.title) AS title'));
        return $this;
    }

    public function behaviors() {
        return [
            NestedSetsQueryBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     * @return \category\models\Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \category\models\Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}