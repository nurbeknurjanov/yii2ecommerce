<?php

namespace user\models\query;
use file\models\File;
use shop\models\UserShop;
use user\models\User;
use yii\db\Expression;
use user\models\Token;
use Yii;
use shop\models\query\UserShopQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[\user\models\User]].
 *
 * @see \user\models\User
 */
class UserQuery extends \yii\db\ActiveQuery
{
    public function mineOrDefault()
    {
        if(Yii::$app->user->can(User::ROLE_ADMINISTRATOR))
            return $this;

        if(Yii::$app->user->isGuest)
            return $this->andWhere("1=0");

        $this->innerJoinWith(['userShops'=>function(UserShopQuery $userShopQuery){
            $userShopQuery->from(['user_shop1'=>  UserShop::tableName()]);
            $userShopQuery->andOnCondition(['user_shop1.shop_id'=>
                ArrayHelper::map(Yii::$app->user->identity->userShops, 'shop_id', 'shop_id') ]);
        }]);

        return $this;
    }

    /**
     * @inheritdoc
     * @return \user\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \user\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function emailQuery($email)
    {
        return $this->andWhere(['user.email'=>$email]);
    }
    public function defaultFrom()
    {
        return $this->from(['user'=>User::tableName()]);
    }

    public function rolesQuery($roles)
    {
        return $this->leftJoin('{{%auth_assignment}} a', 'user.id=a.user_id')
            ->groupBy('user.id')
            ->andWhere(['a.item_name'=>$roles]);
    }

    public function whereFilterName($name=null)
    {
        return $this->andFilterWhere(['LIKE','user.name', $name]);
        //return $this->andFilterWhere(['OR', ['LIKE','user.name', $name], ['LIKE','user.name', $name]]);
    }
}