<?php
/**
 * @author Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace order\rules;

use Yii;
use user\models\User;


class Permissions
{
    public static function run()
    {
        $auth = Yii::$app->authManager;

        $rule = new Rule();
        $auth->add($rule);

        $createOrder = $auth->createPermission('createOrder');
        $auth->add($createOrder);
        $updateOrder = $auth->createPermission('updateOrder');
        $auth->add($updateOrder);
        $deleteOrder = $auth->createPermission('deleteOrder');
        $auth->add($deleteOrder);
        $viewOrder = $auth->createPermission('viewOrder');
        $viewOrder->ruleName = $rule->name;
        $auth->add($viewOrder);
        $indexOrder = $auth->createPermission('indexOrder');
        $indexOrder->description = "The list of orders to manage";
        $auth->add($indexOrder);
        $listOrder = $auth->createPermission('listOrder');
        $listOrder->description = "The list of orders to view";
        $auth->add($listOrder);

        $guestRole = $auth->getRole(User::ROLE_GUEST);
        $userRole = $auth->getRole(User::ROLE_USER);
        $managerRole = $auth->getRole(User::ROLE_MANAGER);
        $auth->addChild($guestRole, $createOrder);
        $auth->addChild($guestRole, $listOrder);
        $auth->addChild($guestRole, $viewOrder);
        $auth->addChild($managerRole, $updateOrder);
        $auth->addChild($managerRole, $deleteOrder);
        $auth->addChild($managerRole, $indexOrder);
    }
}