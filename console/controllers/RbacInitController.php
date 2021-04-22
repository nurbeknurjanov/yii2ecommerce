<?php
/**
 * @author Nurbek Nurjanov nurbek.nurjanov@mail.ru
 * @link http://sakuracommerce.com/
 * @copyright Copyright (c) 2018 Sakuracommerce
 * @license http://sakuracommerce.com/license/
 */

namespace console\controllers;

use yii\console\Controller;
use user\models\User;
use Yii;
use yii\base\Exception;
use yii\helpers\Console;


class RbacInitController extends Controller
{

    public function actionIndex()
    {
        Yii::$app->cache->flush();

        //Yii::$app->authManager->invalidateCache();

        $auth = Yii::$app->authManager;
        $auth->removeAll();


        $guestRole = $auth->createRole(User::ROLE_GUEST);
        $guestRole->description = 'Guest';
        $auth->add($guestRole);
        $userRole = $auth->createRole(User::ROLE_USER);
        $userRole->description = 'Buyer';
        $auth->add($userRole);
        $managerRole = $auth->createRole(User::ROLE_MANAGER);
        $managerRole->description = 'Seller';
        $auth->add($managerRole);
        $administratorRole = $auth->createRole(User::ROLE_ADMINISTRATOR);
        $administratorRole->description = 'Administrator';
        $auth->add($administratorRole);



        $auth->addChild($userRole, $guestRole);
        $auth->addChild($managerRole, $userRole);
        $auth->addChild($administratorRole, $managerRole);


        foreach (User::find()->all() as $user){
            if($user->username=='admin')
                $user->rolesAttribute = User::ROLE_ADMINISTRATOR;
            else
                $user->rolesAttribute = [User::ROLE_MANAGER, User::ROLE_USER];

            $user->saveRoles();
        }



        \user\rules\Permissions::run();
        \product\rules\Permissions::run();
        \category\rules\Permissions::run();
        \favorite\rules\Permissions::run();
        \order\rules\Permissions::run();
        \page\rules\Permissions::run();
        \article\rules\Permissions::run();
        \tag\rules\Permissions::run();
        \comment\rules\Permissions::run();
        \like\rules\Permissions::run();
        \country\rules\Permissions::run();
        \shop\rules\Permissions::run();


        $this->stdout("RBAC successfully initialized\n", Console::FG_GREEN, Console::UNDERLINE);
        //yii cache/flush-all
    }
}