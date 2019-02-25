<?php
/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 11:22 AM
 */

namespace product\rules;

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

        $productRule = new \product\rules\Rule();
        $auth->add($productRule);
        $createProduct = $auth->createPermission('createProduct');
        $auth->add($createProduct);
        $updateProduct = $auth->createPermission('updateProduct');
        $updateProduct->ruleName=$productRule->name;
        $auth->add($updateProduct);
        $deleteProduct = $auth->createPermission('deleteProduct');
        $deleteProduct->ruleName=$productRule->name;
        $auth->add($deleteProduct);
        $viewProduct = $auth->createPermission('viewProduct');
        $auth->add($viewProduct);
        $indexProduct = $auth->createPermission('indexProduct');
        $indexProduct->description = "The list of products to manage";
        $auth->add($indexProduct);
        $listProduct = $auth->createPermission('listProduct');
        $listProduct->description = "The list of products to view";
        $auth->add($listProduct);

        $auth->addChild($userRole, $createProduct);
        $auth->addChild($userRole, $updateProduct);
        $auth->addChild($userRole, $deleteProduct);
        $auth->addChild($guestRole, $viewProduct);
        $auth->addChild($guestRole, $listProduct);
        $auth->addChild($managerRole, $indexProduct);


        $copyProduct = $auth->createPermission('copyProduct');
        $copyProduct->ruleName=$productRule->name;
        $auth->add($copyProduct);
        $auth->addChild($userRole, $copyProduct);

        $exportInstagram = $auth->createPermission('exportInstagram');
        $exportInstagram->ruleName=$productRule->name;
        $auth->add($exportInstagram);
        $auth->addChild($userRole, $exportInstagram);
        $updateInstagram = $auth->createPermission('updateInstagram');
        $updateInstagram->ruleName=$productRule->name;
        $auth->add($updateInstagram);
        $auth->addChild($userRole, $updateInstagram);
        $updateDataInstagram = $auth->createPermission('updateDataInstagram');
        $updateDataInstagram->ruleName=$productRule->name;
        $auth->add($updateDataInstagram);
        $auth->addChild($userRole, $updateDataInstagram);
        $removeInstagram = $auth->createPermission('removeInstagram');
        $removeInstagram->ruleName=$productRule->name;
        $auth->add($removeInstagram);
        $auth->addChild($userRole, $removeInstagram);


    }
}