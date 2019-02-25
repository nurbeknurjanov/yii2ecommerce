<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace article\models\query;
use article\models\Article;

/**
 * This is the ActiveQuery class for [[\article\models\Article]].
 *
 * @see \article\models\Article
 */
class ArticleQuery extends \yii\db\ActiveQuery
{

    public function defaultFrom()
    {
        return $this->from(['article'=>Article::tableName()]);
    }
    public function typeQuery($type)
    {
        return $this->andWhere(['type'=>$type]);
    }

    /**
     * @inheritdoc
     * @return \article\models\Article[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \article\models\Article|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}