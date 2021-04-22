<?php

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace like\rules;

use Yii;
use user\models\User;
use like\rules\Rule;


class Permissions
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $guest = $auth->getRole(User::ROLE_GUEST);
        $user = $auth->getRole(User::ROLE_USER);
        $manager = $auth->getRole(User::ROLE_ADMINISTRATOR);


        $rule = new Rule;
        $auth->add($rule);

        $createLike = $auth->createPermission('createLike');
        $createLike->ruleName=$rule->name;
        $auth->add($createLike);
        $updateLike = $auth->createPermission('updateLike');
        $createLike->ruleName=$rule->name;
        $auth->add($updateLike);
        $deleteLike = $auth->createPermission('deleteLike');
        $createLike->ruleName=$rule->name;
        $auth->add($deleteLike);
        $viewLike = $auth->createPermission('viewLike');
        $auth->add($viewLike);
        $indexLike = $auth->createPermission('indexLike');
        $indexLike->description = "The list of Likes to manage";
        $auth->add($indexLike);

        $auth->addChild($guest, $createLike);
        $auth->addChild($guest, $deleteLike);

        $auth->addChild($user, $createLike);
        $auth->addChild($user, $deleteLike);

        /*$auth->addChild($manager, $updateLike);
        $auth->addChild($manager, $viewLike);*/
        $auth->addChild($manager, $indexLike);

    }

}