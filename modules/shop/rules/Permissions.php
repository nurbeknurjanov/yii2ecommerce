<?php

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace shop\rules;

use Yii;
use user\models\User;


class Permissions
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $guest = $auth->getRole(User::ROLE_GUEST);
        $user = $auth->getRole(User::ROLE_USER);


        $rule = new \shop\rules\Rule();
        $auth->add($rule);

        $createShop = $auth->createPermission('createShop');
        $auth->add($createShop);
        $updateShop = $auth->createPermission('updateShop');
        $updateShop->ruleName = $rule->name;
        $auth->add($updateShop);
        $deleteShop = $auth->createPermission('deleteShop');
        $deleteShop->ruleName = $rule->name;
        $auth->add($deleteShop);
        $viewShop = $auth->createPermission('viewShop');
        $auth->add($viewShop);
        $indexShop = $auth->createPermission('indexShop');
        $indexShop->description = "The list of Shops to manage";
        $auth->add($indexShop);
        $listShop = $auth->createPermission('listShop');
        $listShop->description = "The list of Shops";
        $auth->add($listShop);

        $auth->addChild($user, $createShop);
        $auth->addChild($user, $updateShop);
        $auth->addChild($user, $deleteShop);
        $auth->addChild($guest, $viewShop);
        $auth->addChild($guest, $listShop);
        $auth->addChild($user, $indexShop);

    }

}