<?php

namespace shop\models\query;

use Yii;

/**
 * This is the ActiveQuery class for [[\shop\models\UserShop]].
 *
 * @see \shop\models\UserShop
 */
class UserShopQuery extends \yii\db\ActiveQuery
{
    /*public function defaultFrom()
    {
        return $this->from([''=>]);
    }*/

    /**
     * @inheritdoc
     * @return \shop\models\UserShop[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \shop\models\UserShop|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}