<?php

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace coupon\rules;

use Yii;
use user\models\User;


class Generator
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $moderator = $auth->getRole(User::ROLE_MANAGER);
        $administrator = $auth->getRole(User::ROLE_ADMINISTRATOR);


        $createCoupon = $auth->createPermission('createCoupon');
        $auth->add($createCoupon);
        $updateCoupon = $auth->createPermission('updateCoupon');
        $auth->add($updateCoupon);
        $deleteCoupon = $auth->createPermission('deleteCoupon');
        $auth->add($deleteCoupon);
        $viewCoupon = $auth->createPermission('viewCoupon');
        $auth->add($viewCoupon);
        $indexCoupon = $auth->createPermission('indexCoupon');
        $indexCoupon->description = "The list of Coupons to manage";
        $auth->add($indexCoupon);

        $auth->addChild($moderator, $createCoupon);
        $auth->addChild($moderator, $updateCoupon);
        $auth->addChild($moderator, $deleteCoupon);
        $auth->addChild($moderator, $viewCoupon);
        $auth->addChild($moderator, $indexCoupon);

    }

}