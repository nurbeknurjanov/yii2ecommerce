<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace page\rules;

use Yii;
use user\models\User;


class Permissions
{
    public static function run()
    {
        $auth = Yii::$app->authManager;


        $createPage = $auth->createPermission('createPage');
        $auth->add($createPage);
        $updatePage = $auth->createPermission('updatePage');
        $auth->add($updatePage);
        $deletePage = $auth->createPermission('deletePage');
        $auth->add($deletePage);
        $viewPage = $auth->createPermission('viewPage');
        $auth->add($viewPage);
        $indexPage = $auth->createPermission('indexPage');
        $auth->add($indexPage);

        $guestRole = $auth->getRole(User::ROLE_GUEST);
        $managerRole = $auth->getRole(User::ROLE_MANAGER);


        $auth->addChild($guestRole, $viewPage);
        $auth->addChild($managerRole, $createPage);
        $auth->addChild($managerRole, $updatePage);
        $auth->addChild($managerRole, $deletePage);
        $auth->addChild($managerRole, $indexPage);
    }
}