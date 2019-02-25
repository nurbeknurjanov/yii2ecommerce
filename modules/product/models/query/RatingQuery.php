<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace product\models\query;
use product\models\Rating;

/**
 * This is the ActiveQuery class for [[\product\models\Rating]].
 *
 * @see \product\models\Rating
 */
class RatingQuery extends \yii\db\ActiveQuery
{
    public function defaultFrom()
    {
        $this->from(['rating'=>Rating::tableName()]);
        return $this;
    }

    public function positiveVote()
    {
        return $this->andWhere(['>=', 'factor', 1]);
    }
    /**
     * @inheritdoc
     * @return \product\models\Rating[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \product\models\Rating|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}