<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace category\rules;

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


        $createCategory = $auth->createPermission('createCategory');
        $auth->add($createCategory);
        $updateCategory = $auth->createPermission('updateCategory');
        $auth->add($updateCategory);
        $deleteCategory = $auth->createPermission('deleteCategory');
        $auth->add($deleteCategory);
        $viewCategory = $auth->createPermission('viewCategory');
        $auth->add($viewCategory);
        $indexCategory = $auth->createPermission('indexCategory');
        $indexCategory->description = "The list of categories to manage";
        $auth->add($indexCategory);
        $listCategory = $auth->createPermission('listCategory');
        $listCategory->description = "The list of categories to view";
        $auth->add($listCategory);

        $auth->addChild($managerRole, $createCategory);
        $auth->addChild($managerRole, $updateCategory);
        $auth->addChild($managerRole, $deleteCategory);
        $auth->addChild($userRole, $viewCategory);
        $auth->addChild($userRole, $listCategory);
        $auth->addChild($managerRole, $indexCategory);

    }

}