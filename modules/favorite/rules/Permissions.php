<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 11:18 AM
 */

namespace favorite\rules;

use Yii;
use user\models\User;


class Permissions
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $guestRole = $auth->getRole(User::ROLE_GUEST);
        $managerRole = $auth->getRole(User::ROLE_MANAGER);


        $favoriteRule = new \favorite\rules\Rule();
        $auth->add($favoriteRule);
        $createFavorite = $auth->createPermission('createFavorite');
        $createFavorite->ruleName=$favoriteRule->name;
        $auth->add($createFavorite);
        $deleteFavorite = $auth->createPermission('deleteFavorite');
        $deleteFavorite->ruleName=$favoriteRule->name;
        $auth->add($deleteFavorite);

        $auth->addChild($guestRole, $createFavorite);
        $auth->addChild($guestRole, $deleteFavorite);
    }

}