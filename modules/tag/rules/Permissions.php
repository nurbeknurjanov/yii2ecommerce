<?php

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace tag\rules;

use Yii;
use user\models\User;


class Permissions
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $managerRole = $auth->getRole(User::ROLE_MANAGER);


        $createTag = $auth->createPermission('createTag');
        $auth->add($createTag);
        $updateTag = $auth->createPermission('updateTag');
        $auth->add($updateTag);
        $deleteTag = $auth->createPermission('deleteTag');
        $auth->add($deleteTag);
        $viewTag = $auth->createPermission('viewTag');
        $auth->add($viewTag);
        $indexTag = $auth->createPermission('indexTag');
        $indexTag->description = "The list of categories to manage";
        $auth->add($indexTag);

        $auth->addChild($managerRole, $createTag);
        $auth->addChild($managerRole, $updateTag);
        $auth->addChild($managerRole, $deleteTag);
        $auth->addChild($managerRole, $viewTag);
        $auth->addChild($managerRole, $indexTag);

    }

}