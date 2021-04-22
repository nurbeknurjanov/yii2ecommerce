<?php

namespace shop\models\query;

use user\models\User;
use Yii;

/**
 * This is the ActiveQuery class for [[\shop\models\Shop]].
 *
 * @see \shop\models\Shop
 */
class ShopQuery extends \yii\db\ActiveQuery
{
    public function mineOrDefault()
    {
        if(Yii::$app->user->can(User::ROLE_ADMINISTRATOR))
            return $this;

        $this->innerJoinWith(['userShops'=>function(UserShopQuery $userShopQuery){
            $userShopQuery->andOnCondition(['user_shop.user_id'=>  Yii::$app->user->id]);
        }]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return \shop\models\Shop[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \shop\models\Shop|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}