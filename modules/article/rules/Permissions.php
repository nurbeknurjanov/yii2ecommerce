<?php

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace article\rules;

use Yii;
use user\models\User;


class Permissions
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $guestRole = $auth->getRole(User::ROLE_GUEST);
        $managerRole = $auth->getRole(User::ROLE_MANAGER);


        $createArticle = $auth->createPermission('createArticle');
        $auth->add($createArticle);
        $updateArticle = $auth->createPermission('updateArticle');
        $auth->add($updateArticle);
        $deleteArticle = $auth->createPermission('deleteArticle');
        $auth->add($deleteArticle);
        $viewArticle = $auth->createPermission('viewArticle');
        $auth->add($viewArticle);
        $indexArticle = $auth->createPermission('indexArticle');
        $indexArticle->description = "The list of categories to manage";
        $auth->add($indexArticle);
        $listArticle = $auth->createPermission('listArticle');
        $listArticle->description = "The list of categories to view";
        $auth->add($listArticle);

        $auth->addChild($managerRole, $createArticle);
        $auth->addChild($managerRole, $updateArticle);
        $auth->addChild($managerRole, $deleteArticle);
        $auth->addChild($guestRole, $viewArticle);
        $auth->addChild($guestRole, $listArticle);
        $auth->addChild($managerRole, $indexArticle);

    }

}