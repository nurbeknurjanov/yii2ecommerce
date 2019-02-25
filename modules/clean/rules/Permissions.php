<?php

/**
 * Created by PhpStorm.
 * User: Nurbek Nurjanov <nurbek.nurjanov@mail.ru>
 * Date: 9/23/16
 * Time: 11:20 AM
 */
namespace clean\rules;

use Yii;
use user\models\User;


class Permissions
{
    public static function run()
    {
        $auth = Yii::$app->authManager;
        $moderator = $auth->getRole(User::ROLE_MANAGER);
        $administrator = $auth->getRole(User::ROLE_ADMINISTRATOR);


        $createGrade = $auth->createPermission('createGrade');
        $auth->add($createGrade);
        $updateGrade = $auth->createPermission('updateGrade');
        $auth->add($updateGrade);
        $deleteGrade = $auth->createPermission('deleteGrade');
        $auth->add($deleteGrade);
        $viewGrade = $auth->createPermission('viewGrade');
        $auth->add($viewGrade);
        $indexGrade = $auth->createPermission('indexGrade');
        $indexGrade->description = "The list of grades to manage";
        $auth->add($indexGrade);

        $auth->addChild($moderator, $createGrade);
        $auth->addChild($moderator, $updateGrade);
        $auth->addChild($administrator, $deleteGrade);
        $auth->addChild($moderator, $viewGrade);
        $auth->addChild($moderator, $indexGrade);

    }

}