<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 11:31 AM
 */

namespace user\rules;

use Yii;
use user\models\User;


class Permissions
{
    public static function run()
    {

        $auth = Yii::$app->authManager;
        $guestRole = $auth->getRole(User::ROLE_GUEST);
        $userRole = $auth->getRole(User::ROLE_USER);
        $managerRole = $auth->getRole(User::ROLE_MANAGER);
        $administratorRole = $auth->getRole(User::ROLE_ADMINISTRATOR);


        $userRule = new UserRule();
        $auth->add($userRule);
        $createUser = $auth->createPermission('createUser');
        $auth->add($createUser);
        $updateUser = $auth->createPermission('updateUser');
        $updateUser->ruleName=$userRule->name;
        $auth->add($updateUser);
        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->ruleName=$userRule->name;
        $auth->add($deleteUser);
        $viewUser = $auth->createPermission('viewUser');
        $viewUser->ruleName=$userRule->name;
        $auth->add($viewUser);
        $indexUser = $auth->createPermission('indexUser');
        $indexUser->description = "The list of users to manage";
        $auth->add($indexUser);
        $listUser = $auth->createPermission('listUser');
        $listUser->description = "The list of users";
        $auth->add($listUser);

        $auth->addChild($userRole, $createUser);
        $auth->addChild($userRole, $updateUser);
        $auth->addChild($userRole, $deleteUser);
        $auth->addChild($guestRole, $viewUser);
        $auth->addChild($managerRole, $indexUser);
        $auth->addChild($guestRole, $listUser);
    }
}